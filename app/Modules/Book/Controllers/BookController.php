<?php

namespace App\Modules\Book\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Size\Models\Size;
use App\Modules\Book\Models\Book;

use App\Modules\Theme\Models\Theme;
use App\Modules\Social\Models\Social;
use App\Modules\Setting\Models\Setting;
use App\Modules\Album\Models\Album;

use Validator;
use DB;
use Session;
use Redirect;
use File;
use Auth;
use Storage;
use Image;
use Exception;
use Entrust;

class BookController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Entrust::can('book-view')) { abort(403); }

        $query = Book::orderBy('priority', 'asc');
        if($request->has('name') && !empty($request->name)){
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if($request->has('date') && !empty($request->date)){
            $query->where('date', 'like', '%'.$request->date.'%');
        }
        if($request->has('description') && !empty($request->description)){
            $query->where('description', 'like', '%'.$request->description.'%');
        }
        if($request->has('status') && !empty($request->status)){
            $query->where('status', $request->status);
        }
        if($request->has('thumbnail_size_id') && !empty($request->thumbnail_size_id)){
            $query->where('thumbnail_size_id', $request->thumbnail_size_id);
        }
        if($request->has('size_id') && !empty($request->size_id)){
            $query->where('size_id', $request->size_id);
        }
        $books = $query->paginate(20);

        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        return view("Book::index", compact('books', 'sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Entrust::can('book-create')) { abort(403); }

        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $default_size = Size::whereStatus(true)->whereDefault(true)->first();
        if($default_size){ $default_size_id = $default_size->id; }else{ $default_size_id = null; }
        return view("Book::create", compact('sizes', 'default_size_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Entrust::can('book-create')) { abort(403); }

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'date' => 'sometimes',
            'url' => 'sometimes',
            'video_url' => 'sometimes',
            'social_url' => 'sometimes',
            'youtube' => 'sometimes',
            'status' => 'required',
            'description' => 'sometimes',
            'thumbnail_size_id' => 'required',
            'size_id' => 'required',
            'image' => 'required|image|max:2000'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $last_book_query = Book::orderBy('priority', 'desc');
                if($last_book_query->count() > 0){
                    $last_book = $last_book_query->first();
                    $priority = $last_book->priority + 1;
                }else{
                    $priority = 1;
                }

                $book = new Book;
                $book->name = $request->name;
                $book->date = $request->date;
                $book->url = $request->url;
                $book->video_url = $request->video_url;
                $book->social_url = $request->social_url;
                $book->youtube = $request->youtube;
                $book->status = $request->status;
                $book->description = $request->description;
                $book->thumbnail_size_id = $request->thumbnail_size_id;
                $book->size_id = $request->size_id;
                $book->priority = $priority;

                $thumb_size = Size::where('id', $request->thumbnail_size_id)->first();
                $size = Size::where('id', $request->size_id)->first();
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                $thumb_url = 'uploads/photos/thumb/';
                $url = 'uploads/photos/full/';
                $thumb = Image::make($request->file('image'))->resize($thumb_size->width, $thumb_size->height)->save($thumb_url.$fileName);
                $img = Image::make($request->file('image'))->resize($size->width, $size->height)->save($url.$fileName);
                $book->image = $fileName;

                $book->created_by = Auth::id();
                $book->updated_by = Auth::id();
                $book->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'A new book is created',
            );
            Session::flash('message', $message);
            return Redirect('/panel/books');

        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to create new book',
            );
            Session::flash('message', $message);
            return Redirect('/panel/books');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Entrust::can('book-update')) { abort(403); }

        $book = Book::findOrFail($id);
        $sizes = Size::whereStatus(true)->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
        return view("Book::edit", compact('book', 'sizes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!Entrust::can('book-update')) { abort(403); }

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'date' => 'sometimes',
            'url' => 'sometimes',
            'video_url' => 'sometimes',
            'social_url' => 'sometimes',
            'youtube' => 'sometimes',
            'status' => 'required',
            'description' => 'sometimes',
            'thumbnail_size_id' => 'required',
            'size_id' => 'required',
            'image' => 'sometimes|image|max:2000'
        ]);

        if($validation->fails()) {
            return Redirect::back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();

                $book = Book::findOrFail($id);
                $book->name = $request->name;
                $book->date = $request->date;
                $book->url = $request->url;
                $book->video_url = $request->video_url;
                $book->social_url = $request->social_url;
                $book->youtube = $request->youtube;
                $book->status = $request->status;
                $book->description = $request->description;

                if($request->hasFile('image')){
                    $book->thumbnail_size_id = $request->thumbnail_size_id;
                    $book->size_id = $request->size_id;

                    $thumb_size = Size::where('id', $request->thumbnail_size_id)->first();
                    $size = Size::where('id', $request->size_id)->first();
                    $extension = $request->file('image')->getClientOriginalExtension();

                    $fileName = str_replace(' ', '-', strtolower($request->name)).'-'.time().'.'.$extension;
                    $thumb_url = 'uploads/photos/thumb/';
                    $url = 'uploads/photos/full/';
                    $thumb = Image::make($request->file('image'))->resize($thumb_size->width, $thumb_size->height)->save($thumb_url.$fileName);
                    $img = Image::make($request->file('image'))->resize($size->width, $size->height)->save($url.$fileName);

                    $book->image = $fileName;
                }

                $book->updated_by = Auth::id();
                $book->save();

            DB::commit();

            $message = array(
                'class' => 'success',
                'title' => 'Success',
                'text' => 'The book is updated',
            );
            Session::flash('message', $message);
            return Redirect('/panel/books');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to update book',
            );
            Session::flash('message', $message);
            return Redirect('/panel/books');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Entrust::can('book-delete')) { abort(403); }

        try {
            DB::beginTransaction();

                $book = Book::where('id', $id)->delete();

                if($book){
                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully deleted the book',
                    );
                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That book can't be delete",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect('/panel/books');

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to delete the book',
            );
            Session::flash('message', $message);
            return Redirect('/panel/books');
        }
    }

    public function up($id)
    {
        if(!Entrust::can('book-update')) { abort(403); }

        try {
            DB::beginTransaction();

                $temp_book = Book::whereStatus(true)->where('id', $id)->first();
                $exchange_book = Book::whereStatus(true)->where('priority', '<', $temp_book->priority)->orderBy('priority', 'desc')->first();

                if($exchange_book && $temp_book){
                    $book_priority = $temp_book->priority;
                    $exchange_book_priority = $exchange_book->priority;

                    $temp_book->priority = 0;
                    $temp_book->save();

                    $exchange_book->priority = $book_priority;
                    $exchange_book->save();

                    $book = Book::findOrFail($id);
                    $book->priority = $exchange_book_priority;
                    $book->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the book',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That book can't be up",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect::back();

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to up the book',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }

    public function down($id)
    {
        if(!Entrust::can('book-update')) { abort(403); }

        try {
            DB::beginTransaction();

                $temp_book = Book::whereStatus(true)->where('id', $id)->first();
                $exchange_book = Book::whereStatus(true)->where('priority', '>', $temp_book->priority)->orderBy('priority', 'asc')->first();

                if($exchange_book && $temp_book){
                    $book_priority = $temp_book->priority;
                    $exchange_book_priority = $exchange_book->priority;

                    $temp_book->priority = 0;
                    $temp_book->save();

                    $exchange_book->priority = $book_priority;
                    $exchange_book->save();

                    $book = Book::findOrFail($id);
                    $book->priority = $exchange_book_priority;
                    $book->save();

                    $message = array(
                        'class' => 'success',
                        'title' => 'Success',
                        'text' => 'Successfully updated the book',
                    );

                }else{
                    $message = array(
                        'class' => 'warning',
                        'title' => 'Failed',
                        'text' => "That book can't be down",
                    );
                }

            DB::commit();

            Session::flash('message', $message);
            return Redirect::back();

        } catch (Exception $e) {
            DB::rollBack();
            $message = array(
                'class' => 'danger',
                'title' => 'Failed',
                'text' => 'Failed to down the book',
            );
            Session::flash('message', $message);
            return Redirect::back();
        }
    }

    public function view()
    {
        $theme = Theme::where('status', 1)->where('default', 1)->first();
        $setting = Setting::FindOrFail(1);
        $albums = Album::whereStatus(true)->orderBy('priority', 'asc')->get();
        $socials = Social::whereStatus(true)->orderBy('priority', 'asc')->get();

        $books = Book::whereStatus(1)->orderBy('priority', 'asc')->paginate(5);

        return view('templates.'.$theme->folder.'.book.index', compact('theme', 'setting', 'albums', 'socials', 'books'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $theme = Theme::where('status', 1)->where('default', 1)->first();
        $setting = Setting::FindOrFail(1);
        $albums = Album::whereStatus(true)->orderBy('priority', 'asc')->get();
        $socials = Social::whereStatus(true)->orderBy('priority', 'asc')->get();

        $book = Book::findOrFail($id);

        return view('templates.'.$theme->folder.'.book.show', compact('theme', 'setting', 'albums', 'socials', 'book'));
    }
}
