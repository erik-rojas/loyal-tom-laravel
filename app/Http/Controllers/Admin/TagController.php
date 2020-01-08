<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::where('category', 'character')->get();
        return view('admin.tags.index')->withTags($tags);
    }

    public function tagUpdate(Request $request)
    {
        $tag = Tag::find($request->tag_id);
        $tag->name = $request->new_tag_name;
        $tag->save();

        return('success');
    }

    public function tagDelete(Request $request)
    {
        $tag = Tag::find($request->tag_id);
        $tag->ideas()->detach();
        $tag->delete();

        return ('success');
    }

    public function tagStore(Request $request)
    {
        $tag = new Tag();
        $tag->name = $request->new_tag_name;
        $tag->category = 'character';
        $tag->save();

        Session::flash('success', 'New Tag: '.$tag->name.' was created successfully!');

        return redirect()->route('tags.index');
    }
}
