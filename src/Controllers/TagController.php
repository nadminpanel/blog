<?php

namespace NAdminPanel\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use NAdminPanel\AdminPanel\Repositories\AdminPanelRepository;
use NAdminPanel\Blog\Models\Tag;
use NAdminPanel\Blog\Requests\TagRequest;
use Yajra\Datatables\Facades\Datatables;

class TagController extends Controller
{
    protected $accessPermission;
    protected $viewDir;
    protected $adminRepo;

    public function __construct()
    {
        $this->accessPermission = ' '.'tag';
        $this->viewDir = 'nap-blog::';
        $this->adminRepo = new AdminPanelRepository;
    }

    public function index(Request $request)
    {
        $this->adminRepo->isHasPermissionAccess('show'.$this->accessPermission, $request);

        if ($request->ajax()) {
            $query = Tag::all();
            return $this->datatable($query);
        }
        return view($this->viewDir . 'tag.indexOrArchive');
    }

    public function create()
    {
        $this->adminRepo->isHasPermissionAccess('create'.$this->accessPermission);

        return view($this->viewDir.'tag.createOrEdit');
    }

    public function store(TagRequest $request)
    {
        $this->adminRepo->isHasPermissionAccess('create'.$this->accessPermission);

        $tag = new Tag;
        $tag->name = $request->input('name');
        $tag->description = $request->input('description');
        $tag->save();

        return redirect()->route('tag.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $this->adminRepo->isHasPermissionAccess('edit'.$this->accessPermission);

        $tag = Tag::find($id);
        return view($this->viewDir.'tag.createOrEdit', compact('tag'));
    }

    public function update(TagRequest $request, $id)
    {
        $this->adminRepo->isHasPermissionAccess('edit'.$this->accessPermission);

        $tag = Tag::find($id);
        if($tag)
        {
            $tag->name = $request->input('name');
            $tag->description = $request->input('description');
            $tag->save();
        }

        return redirect()->route('tag.index');
    }

    public function destroy($id)
    {
        $this->adminRepo->isHasPermissionAccess('delete'.$this->accessPermission);

        Tag::destroy($id);
        return response()->json(['status'=>'deleted']);
    }

    public function indexArchive(Request $request)
    {
        $this->adminRepo->isHasPermissionAccess('show'.$this->accessPermission, $request);

        if($request->ajax()){
            $query = Tag::onlyTrashed()->get();
            return Datatables::of($query)
                ->addColumn('action', function ($tag) {
                    return view($this->viewDir.'blog.datatable.tag', compact('tag'))->render();
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
        return view($this->viewDir.'tag.indexOrArchive');
    }

    public function unarchive(Request $request, $id)
    {
        $this->adminRepo->isHasPermissionAccess('edit'.$this->accessPermission);

        Tag::onlyTrashed()->findOrFail($id)->restore();
        if ($request->ajax()) {
            return response()->json(['status' => 'unarchived']);
        }
    }

    public function destroyArchive(Request $request, $id)
    {
        $this->adminRepo->isHasPermissionAccess('delete'.$this->accessPermission);

        Tag::onlyTrashed()->findOrFail($id)->forceDelete();
        if ($request->ajax()) {
            return response()->json(['status'=>'deleted']);
        }
    }

    private function datatable($query)
    {
        return Datatables::of($query)
            ->addColumn('action', function ($tag) {
                return view($this->viewDir . 'blog.datatable.tag', compact('tag'))->render();
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }
}
