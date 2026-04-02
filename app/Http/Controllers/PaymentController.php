<?php

namespace App\Http\Controllers;

use App\Models\HotpatchApp;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Stripe\StripeClient;
use Stripe\Webhook;

class PaymentController extends Controller
{
    private $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
    }

    public function webIndex()
    {
        $app = HotpatchApp::where('owner_id', auth()->id())->firstOrFail();
        return view('billing', ['app' => $app]);
    }

    public function checkout(Request $request)
    {
        $request->validate(['tier' => 'required|string']);
        $app = HotpatchApp::where('owner_id', auth()->id())->firstOrFail();

        // Map tier to price ID
        $priceId = env('STRIPE_PRICE_ID_PRO'); // Default Pro
        if ($request->tier === 'enterprise') {
            $priceId = env('STRIPE_PRICE_ID_ENT');
        }

        // Create or get customer
        if (!$app->stripe_customer_id) {
            $customer = $this->stripe->customers->create([
                'email' => auth()->user()->email,
                'name' => $app->name,
                'metadata' => ['app_id' => $app->id],
            ]);
            $app->update(['stripe_customer_id' => $customer->id]);
        }

        $session = $this->stripe->checkout->sessions->create([
            'customer' => $app->stripe_customer_id,
            'mode' => 'subscription',
            'success_url' => env('FRONTEND_URL') . '/dashboard/billing?success=true',
            'cancel_url' => env('FRONTEND_URL') . '/dashboard/billing?canceled=true',
            'line_items' => [[
                'price' => $priceId,
                'quantity' => 1,
            ]],
            'metadata' => [
                'app_id' => $app->id,
                'tier' => $request->tier,
            ],
        ]);

        return response()->json(['url' => $session->url]);
    }

    public function portal(Request $request)
    {
        $app = HotpatchApp::where('owner_id', auth()->id())->firstOrFail();
        if (!$app->stripe_customer_id) {
            return response()->json(['error' => 'No stripe customer found'], 400);
        }

        $session = $this->stripe->billingPortal->sessions->create([
            'customer' => $app->stripe_customer_id,
            'return_url' => env('FRONTEND_URL') . '/dashboard/billing',
        ]);

        return response()->json(['url' => $session->url]);
    }

    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Bad signature'], 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $this->handleCheckoutCompleted($event->data->object);
                break;
            case 'customer.subscription.deleted':
            case 'customer.subscription.updated':
                $this->handleSubscriptionChange($event->data->object);
                break;
        }

        return response()->json(['status' => 'ok']);
    }

    private function handleCheckoutCompleted($session)
    {
        $appId = $session->metadata->app_id;
        $tier = $session->metadata->tier;
        $app = HotpatchApp::findOrFail($appId);

        $subscription = $this->stripe->subscriptions->retrieve($session->subscription);

        $app->update([
            'tier' => $tier,
            'stripe_subscription_id' => $session->subscription,
            'subscription_status' => 'active',
            'subscription_end' => date('Y-m-d H:i:s', $subscription->current_period_end)
        ]);

        $this->logBillingAction($app->id, 'billing.subscription_started', $session->subscription, "Tier: {$tier}");
    }

    private function handleSubscriptionChange($subscription)
    {
        $app = HotpatchApp::where('stripe_subscription_id', $subscription->id)->first();
        if (!$app) return;

        if ($subscription->status === 'canceled' || $subscription->status === 'unpaid') {
            $app->update([
                'tier' => 'free',
                'subscription_status' => $subscription->status,
                'stripe_subscription_id' => null
            ]);
            $this->logBillingAction($app->id, 'billing.subscription_canceled', $subscription->id);
        } else {
            $app->update([
                'subscription_status' => $subscription->status,
                'subscription_end' => date('Y-m-d H:i:s', $subscription->current_period_end)
            ]);
            $this->logBillingAction($app->id, 'billing.subscription_updated', $subscription->id);
        }
    }

    private function logBillingAction($appId, $action, $entityId, $metadata = null)
    {
        AuditLog::create([
            'id' => (string) Str::uuid(),
            'app_id' => $appId,
            'actor' => 'Stripe Webhook',
            'action' => $action,
            'entity_id' => $entityId,
            'metadata' => $metadata,
            'ip_address' => request()->ip(),
        ]);
    }
}
