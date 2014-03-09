<?php
class ImageController extends BaseController
{
    public function getIndex()
    {
        return View::make('tpl.index');
    }

    public function getAll()
    {
        $all_images = Photo::orderBy('id', 'desc')->paginate(6);
        
        return View::make('tpl.all_images')
            ->with('images', $all_images);
    }

    public function getSnatch($id)
    {
        $image = Photo::find($id);

        if ($image) {
            return View::make('tpl.permalink')
                ->with('image', $image);
        }

        return Redirect::to('/')
            ->with('error', 'Image not found');
    }

    public function getDelete($id)
    {
        $image = Photo::find($id);

        if ($image) {

            File::delete(Config::get('image.upload_folder') . '/' . $image->image);
            File::delete(Config::get('image.thumb_folder') . '/' . $image->image);
            $image->delete();

            return Redirect::to('/')
                ->with('success', 'Image deleted successfully');
        }

        return Redirect::to('/')
            ->with('error', 'No image with such ID found');
    }

    public function postIndex()
    {
        $validation = Validator::make(Input::all(), Photo::$upload_rules);

        if ($validation->fails()) {
            return Redirect::to('/')
                ->withInput()
                ->withErrors($validation);
        }

        $image    = Input::file('image');
        $filename = $image->getClientOriginalName();
        $filename = pathinfo($filename, PATHINFO_FILENAME);
        $fullname = Str::slug(Str::random(8) . $filename) . '.' . $image->getClientOriginalExtension();

        $upload = $image->move(Config::get('image.upload_folder'), $fullname);

        Image::make(Config::get('image.upload_folder') . '/' . $fullname)
            ->resize(Config::get('image.thumb_width'), null, true)
            ->save(Config::get('image.thumb_folder') . '/' . $fullname);

        if ($upload) {

            $photo = new Photo;
            $photo->title = Input::get('title');
            $photo->image = $fullname;
            $photo->save();

            return Redirect::to(URL::to('snatch/' . $photo->id))
                ->with('success', 'Your image was upload successfully!');
        } 

        return Redirect::to('/')
            ->withInput()
            ->with('error', 'Sorry, the image could not be uploaded. Please try again later');
    }
}