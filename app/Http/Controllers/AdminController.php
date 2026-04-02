<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\HotpatchApp;
use App\Models\Release;
use App\Models\Device;
use App\Models\Blog;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_apps' => HotpatchApp::count(),
            'total_releases' => Release::count(),
            'total_devices' => Device::count(),
            'total_users' => User::count(),
            'status' => 'operational'
        ];

        return view('admin.dashboard', [
            'stats' => $stats
        ]);
    }

    public function apps()
    {
        $apps = HotpatchApp::with('owner')->get();
        return view('admin.apps', ['apps' => $apps]);
    }

    public function users()
    {
        $users = User::paginate(20);
        return view('admin.users', ['users' => $users]);
    }

    public function blogs()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->get();
        return view('admin.blogs', ['blogs' => $blogs]);
    }

    public function createBlog(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author' => 'required|string',
        ]);

        $blog = Blog::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title),
            'content' => $request->content,
            'author' => $request->author,
            'is_published' => $request->is_published ?? false,
        ]);

        return response()->json($blog, 201);
    }

    public function updateBlog(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->update($request->all());
        
        // Update slug if title changed
        if ($request->has('title')) {
            $blog->update(['slug' => \Illuminate\Support\Str::slug($request->title)]);
        }

        return response()->json($blog);
    }

    public function deleteBlog($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
