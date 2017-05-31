<?php

namespace NAdminPanel\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use NAdminPanel\AdminPanel\Repositories\AdminPanelRepository;
use NAdminPanel\Blog\Models\Category;
use NAdminPanel\Blog\Models\Post;
use NAdminPanel\Blog\Requests\PostRequest;
use Yajra\Datatables\Facades\Datatables;

class PostController extends Controller
{
    protected $accessPermission;
    protected $viewDir;
    protected $adminRepo;

    public function __construct()
    {
        $this->accessPermission = ' '.'post';
        $this->viewDir = 'nap-blog::';
        $this->adminRepo = new AdminPanelRepository;
    }

    public function index(Request $request)
    {
        $this->adminRepo->isHasPermissionAccess('show'.$this->accessPermission, $request);

        if ($request->ajax()) {
            $query = Post::all();
            return Datatables::of($query)
                ->addColumn('action', function ($post) {
                    return view($this->viewDir . 'blog.datatable.post', compact('post'))->render();
                })
                ->addColumn('short_description', function ($post) {
                    return ((strlen(strip_tags($post->description)) > 200) ? (mb_substr(strip_tags($post->description), 0, 200).'...') : strip_tags($post->description));
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
        return view($this->viewDir . 'post.indexOrArchive');
    }

    public function create()
    {
        $this->adminRepo->isHasPermissionAccess('create'.$this->accessPermission);

        $categories = Category::all();
        return view($this->viewDir.'post.createOrEdit', compact('categories'));
    }

    public function store(PostRequest $request)
    {
        $this->adminRepo->isHasPermissionAccess('create'.$this->accessPermission);

        $post = new Post;
        $post->featured = ($request->has('featured') && $request->input('featured') == 'on') ? true : false;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->user_id = auth()->user()->id;
        $post->category_id = $request->input('category');
        $post->published_at = $request->input('published_at');
        $post->save();

        return redirect()->route('post.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $this->adminRepo->isHasPermissionAccess('edit'.$this->accessPermission);

        $categories = Category::all();
        $post = Post::find($id);
        return view($this->viewDir.'post.createOrEdit', compact('post', 'categories'));
    }

    public function update(PostRequest $request, $id)
    {
        $this->adminRepo->isHasPermissionAccess('edit'.$this->accessPermission);

        $post = Post::find($id);
        if($post)
        {
            $post->name = $request->input('name');
            $post->description = $request->input('description');
            $post->save();
        }

        return redirect()->route('post.index');
    }

    public function destroy($id)
    {
        $this->adminRepo->isHasPermissionAccess('delete'.$this->accessPermission);

        Post::destroy($id);
        return response()->json(['status'=>'deleted']);
    }

    public function indexArchive(Request $request)
    {
        $this->adminRepo->isHasPermissionAccess('show'.$this->accessPermission, $request);

        if($request->ajax()){
            $query = Post::onlyTrashed()->get();
            return Datatables::of($query)
                ->addColumn('action', function ($post) {
                    return view($this->viewDir.'blog.datatable.post', compact('post'))->render();
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
        return view($this->viewDir.'post.indexOrArchive');
    }

    public function unarchive(Request $request, $id)
    {
        $this->adminRepo->isHasPermissionAccess('edit'.$this->accessPermission);

        Post::onlyTrashed()->findOrFail($id)->restore();
        if ($request->ajax()) {
            return response()->json(['status' => 'unarchived']);
        }
    }

    public function destroyArchive(Request $request, $id)
    {
        $this->adminRepo->isHasPermissionAccess('delete'.$this->accessPermission);

        Post::onlyTrashed()->findOrFail($id)->forceDelete();
        if ($request->ajax()) {
            return response()->json(['status'=>'deleted']);
        }
    }
}
