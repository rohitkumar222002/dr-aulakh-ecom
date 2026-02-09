<?php

namespace App\Http\Controllers\Basic;

use Illuminate\Http\Request;
use App\Models\Slider\Slider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    public function Sliders()
    {
        $sliders = Slider::where('user_id', Auth::id())->where('guard',current_guard())->paginate(10);
        return view('admin.sliders.sliders', compact('sliders'));
    }
    public function SlidersStore(Request $request)
    {
        $request->validate([
            'image' => 'required',
            'status' => 'required|integer|in:0,1',
            'link'    => 'nullable',
        ]);

        $slider = new Slider();
        $slider->user_id = Auth::id();
        $slider->guard = current_guard();
        $slider->images = $request->image;
        $slider->link = $request->slider_link;
        $slider->status = $request->status;
        $slider->save();
        return redirect()->back()->with('success', 'Slider added successfully!');
    }

    public function SliderUpdate(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sliders,id',
            'images' => 'required',
            'status' => 'required|integer|in:0,1',
            'link'    => 'nullable',
        ]);

        $slider = Slider::where('user_id', Auth::id())
            ->where('guard', current_guard())
            ->findOrFail($request->id);

        $slider->images = $request->images;
        $slider->link = $request->slider_link;
        $slider->status = $request->status;


        if ($slider->save()) {
            return redirect()->back()->with('success', 'Slider updated successfully!');
        }

        return redirect()->back()->with('error', 'Slider not updated.');
    }


    public function SliderDelete($id)
    {
        $slider = Slider::where('user_id', Auth::id())->where('guard', current_guard())->findOrFail($id);
        if ($slider->delete()) {
            return response()->json(['success' => 'Item deleted successfully.']);
        }
        return response()->json(['error' => 'Item not deleted.']);
    }
}
