<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use Illuminate\Support\Facades\Storage;
use Session;
use App\Currency;
use App\Idea;
use App\IdeaDate;
use App\IdeaImage;
use App\Tag;
use App\Feedback;
use DB;

class IdeaController extends Controller
{
    /**
     * @return 50 Ideas per page + All Tags for Filter
     */
    public function index()
    {
        $ideas = Idea::orderBy('id', 'desc')->paginate(50);

        $tags = Tag::get();
        $selected_tags = [];
        session()->forget('selected_tags');

        return view('admin.idea.index')->withIdeas($ideas)->withTags($tags)->withSelected_tags($selected_tags)->withStatus('');
    }

    /**
     * @param Request $request - Search Request
     * @return Search Results
     */
    public function search(Request $request)
    {
        // Определим сообщение, которое будет отображаться, если ничего не найдено 
        // или поисковая строка пуста
        $errors = ['errors' => 'No results found, please try with different keywords.'];

        $tags = Tag::all();

        // Удостоверимся, что поисковая строка есть
        if($request->has('q')) {

            // Используем синтаксис Laravel Scout для поиска по таблице products.
            $ideas = Idea::search($request->get('q'))->get();

            // Если есть результат есть, вернем его, если нет  - вернем сообщение об ошибке.
            if($ideas->count()){
                return view('admin.idea.search')->withIdeas($ideas)->withSearch($request->get('q'))->withTags($tags);
            }
            else{
                 Session::flash('warning', 'Nothing Found!');
                return view('admin.idea.search')->withSearch($request->get('q'))->withTags($tags);
            }
        }

        $ideas = array();
        Session::flash('warning', 'Nothing Found!');
        return view('admin.idea.search')->withIdeas($ideas)->withTags($tags);
    }

    /**
     * @param Request $request - Tags IDS for filtration
     * @return Filtered Ideas
     */
    public function filter(Request $request)
    {
        if(!$request->tags){
            if(session('selected_tags')){
                $selected_tags = session('selected_tags');
            }
            else{
                $selected_tags = Tag::pluck('id')->all();
                session(['selected_tags' => [] ]);
            }
        }
        else{
            $selected_tags = $request->tags;
            session(['selected_tags' => $selected_tags]);
        }

        if($request->status){
            $status = $request->status;
        }
        elseif(session('status')){
            $status = session('status');
        }
        else{
            $status = 'I LIKE THIS IDEA';
        }
        session(['status' => $status]);

        $ideas = Idea::whereHas('tags', function ($query) use ($selected_tags){
            $query->whereIn('tags.id', $selected_tags);
        })
            ->withCount(['feedbacks'=> function ($query) use ($status){
            $query->where('status', $status);
        }])
            ->orderBy('feedbacks_count', 'desc')
            ->paginate(50);

        $tags = Tag::all();

        return view('admin.idea.index')->withIdeas($ideas)->withTags($tags)->withSelected_tags(session('selected_tags'))->withStatus($status);
    }

    /**
     * @return View for creating new idea
     */
    public function create()
    {
        $tags = Tag::all();
        $currencies = Currency::all();

        return view('admin.idea.create')->withTags($tags)->withCurrencies($currencies);
    }

    /**
     * @param Request $request - New Idea
     *
     * @return Redirect to new created Idea
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'headline'              => 'required|min:3|max:255',
            'description'           => 'required',
            'main_image'            => 'required',
            'url'                   => 'required|min:3',
            'price'                 => 'required|numeric',
            'additional_price'      => 'required|numeric',
        ));

        $idea = new Idea();
        $idea->headline = $request->headline;
        $idea->description = $request->description;
        $idea->video = $request->video;
        $idea->price = $request->price;
        $idea->additional_price = $request->additional_price;
        $idea->currency_id = $request->currency_id;
        $idea->url = $request->url;
        $idea->address = $request->address;
        $idea->button_buy_text = $request->button_buy_text;
        $idea->button_buy_for_me_text = $request->button_buy_for_me_text;

        //Save Image
        if ($request->hasfile('main_image')){
            $image = $request->file('main_image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $location = public_path('upload/ideas/images/'.$filename);
            $img = Image::make($image);
            $img->resize(null, 430, function ($constraint) {
                $constraint->aspectRatio();
            })->crop(640, 430);
            $img->save($location);

            $idea->image = $filename;
        }

        $idea->save();

        //Save images
        if(isset($request['additional_images'])){
            foreach($request['additional_images'] as $image){
                $filename = time().rand(1, 100).'.'.$image->getClientOriginalExtension();
                $location = public_path('upload/ideas/images/'.$filename);
                $img = Image::make($image);
                $img->resize(null, 430, function ($constraint) {
                    $constraint->aspectRatio();
                })->crop(640, 430);
                $img->save($location);

                $ideaImage = new IdeaImage();
                $ideaImage->idea_id = $idea->id;
                $ideaImage->name = $filename;
                $ideaImage->save();
            }
        }

        //Save Dates
        if(isset($request->daterange)){
            foreach ($request->daterange as $date){
                $ideaDate = new IdeaDate();
                $ideaDate->idea_id = $idea->id;
                $ideaDate->date = $date;
                $ideaDate->save();
            }
        }

        //Tags
        if (isset($request->tags)){
            $idea->tags()->sync($request->tags, false);
        }
        else{
            $idea->tags()->sync(array());
        }

        Session::flash('success', 'Idea was created successfully!');
        return redirect()->route('ideas.show', $idea->id);
    }


    /**
     * @param $id - Idea id
     * @return Show requested idea
     */
    public function show($id)
    {
        $idea = Idea::find($id);
        $likes = Feedback::where('idea_id', $id)->where('status', 'I LIKE THIS IDEA')->get();
        $dislikes = Feedback::where('idea_id', $id)->where('status', "Don't show me this idea any more")->get();
        $purchases = Feedback::where('idea_id', $id)->where('status', 'I purchased this idea')->get();
        $mismatch = Feedback::where('idea_id', $id)->where('status', 'Don’t show this idea for this client')->get();
        return view('admin.idea.show')
            ->withIdea($idea)
            ->withLikes($likes)
            ->withDislikes($dislikes)
            ->withPurchases($purchases)
            ->withMismatch($mismatch);
    }

    /**
     * @param $id Idea id
     * @return View with this Idea
     */
    public function edit($id)
    {
        $idea = Idea::find($id);
        $tags = Tag::all();
        $currencies = Currency::all();

        return view('admin.idea.edit')->withIdea($idea)->withTags($tags)->withCurrencies($currencies);
    }

    /**
     * @param Request $request - Idea with edits
     * @param $id - Idea id
     * @return Show this idea with updates
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, array(
            'headline'              => 'required|min:3|max:255',
            'description'           => 'required',
            'url'                   => 'required|min:3',
            'price'                 => 'required|numeric',
            'additional_price'      => 'required|numeric',

        ));

        $idea = Idea::find($id);
        $idea->headline = $request->headline;
        $idea->description = $request->description;
        $idea->video = $request->video;
        $idea->price = $request->price;
        $idea->additional_price = $request->additional_price;
        $idea->currency_id = $request->currency_id;
        $idea->url = $request->url;
        $idea->address = $request->address;
        $idea->button_buy_text = $request->button_buy_text;
        $idea->button_buy_for_me_text = $request->button_buy_for_me_text;

        //Save Image
        if ($request->hasfile('main_image')){
            $image = $request->file('main_image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $location = public_path('upload/ideas/images/'.$filename);
            $img = Image::make($image);
            $img->resize(null, 430, function ($constraint) {
                $constraint->aspectRatio();
            })->crop(640, 430);
            $img->save($location);

            $idea->image = $filename;
        }

        $idea->save();

        //Save images
        if(isset($request['additional_images'])){
            foreach($request['additional_images'] as $image){
                $filename = time().rand(1, 100).'.'.$image->getClientOriginalExtension();
                $location = public_path('upload/ideas/images/'.$filename);
                $img = Image::make($image);
                $img->resize(null, 430, function ($constraint) {
                    $constraint->aspectRatio();
                })->crop(640, 430);
                $img->save($location);

                $ideaImage = new IdeaImage();
                $ideaImage->idea_id = $idea->id;
                $ideaImage->name = $filename;
                $ideaImage->save();
            }
        }

        //Save Dates
        $idea->dates()->delete();

        if(isset($request->daterange)){
            foreach ($request->daterange as $date){
                $ideaDate = new IdeaDate();
                $ideaDate->idea_id = $idea->id;
                $ideaDate->date = $date;
                $ideaDate->save();
            }
        }

        //Tags
        if (isset($request->tags)){
            $idea->tags()->sync($request->tags, true);
        }
        else{
            $idea->tags()->sync(array());
        }

        Session::flash('success', 'Idea was updated successfully!');
        return redirect()->route('ideas.show', $idea->id);
    }

    /**
     * @param $id - Idea id
     * @return Ideas index view
     */
    public function destroy($id)
    {
        $idea = Idea::find($id);
        Storage::delete('/upload/ideas/images/'.$idea->image);
        foreach($idea->ideaImages as $image){
            Storage::delete('/upload/ideas/images/'.$image->name);
            $image->delete();
        }

        $idea->tags()->detach();
        $idea->dates()->delete();
        $idea->delete();

        Session::flash('success', 'Idea was deleted successfully!');

        return redirect()->route('ideas.index');

    }

    /**
     * @param AJAX Request $request with image id
     * @return success
     */
    public function imageDelete(Request $request)
    {
        $image = IdeaImage::find($request->id);
        Storage::delete('/upload/ideas/images/'.$image->name);
        $image->delete();

        return ('success');
    }

    public function  pullIdeas ()
    {
        $localIdea = Idea::latest()->first();

        $ideas = new Idea();
        $ideas->setConnection('mysql_sc');

        $ideas = $ideas->get();
        dd($ideas);

    }
}
