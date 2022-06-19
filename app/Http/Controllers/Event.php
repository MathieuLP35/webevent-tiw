<?php

namespace App\Http\Controllers;

use App\Models\Event as ModelsEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Event extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = ModelsEvent::all();

        try{
            return response()->view('pages.event.list', [
                'events' => $events,
            ]);
        }
        catch(\Exception $e){
            return response()->view('pages.event.list', [
                'events' => [],
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = new ModelsEvent;
        $event->title = $request->title;
        $event->description = $request->description;
        $event->date = $request->date;
        $event->slots = $request->slots;
        $event->author_id = Auth::user()->id;
        $event->save();

        $event->registerEvent(Auth::user()->id);

        return redirect('event');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = ModelsEvent::find($id);
        try{
            return response()->view('pages.event.show', [
                'event' => $event,
            ]);
        }
        catch(\Exception $e){
            return response()->view('pages.event.show', [
                'event' => [],
            ]);
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
        try{
            $event = ModelsEvent::findOrFail($id);
            return view('pages.event.edit', [
                'event' => $event,
            ]);
        }
        catch(\Exception $e){
            return redirect('event');
        }

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
        try{
            $event = ModelsEvent::findOrFail($id);
            if ($event->author_id == Auth::user()->id) {
                $event->title = $request->title;
                $event->description = $request->description;
                $event->date = $request->date;
                $event->slots = $request->slots;
                $event->save();
    
                return redirect('event')->with('successMsg', 'Event modifier avec succès');;
            }
            else{
                return redirect('event')->with('errorMsg', 'Vous n\'êtes pas autorisé à modifier cet event !');
            }
        }
        catch(\Exception $e){
            return redirect('event')->with('errorMsg', 'Erreur lors de la modification de l\'event !');
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
        try{
            $event = ModelsEvent::find($id);
            if ($event->author_id == Auth::user()->id) {
                $event->delete();
                return redirect('event')->with('successMsg', 'Event supprimer avec succès');
            }
            else{
                return redirect('event')->with('errorMsg', 'Vous n\'êtes pas autorisé à supprimer cet event !');
            }
        }
        catch(\Exception $e){
            return redirect('event')->with('errorMsg', 'Erreur lors de la suppression de l\'event !');
        }
    }

    public function registerEvent($id)
    {
       try{
            $event = ModelsEvent::findOrFail($id);
            if ($event->subcriptions()->count() < $event->slots) {
                if ($event->date >= date('Y-m-d')) {
                    $event->registerEvent(Auth::user()->id);
                    return redirect('event')->with('successMsg', 'Vous êtes inscrit à l\'event !');
                }
                else{
                    return redirect('event')->with('errorMsg', 'Cet event est déjà passé !');
                }
            }
            else{
                return redirect('event')->with('errorMsg', 'Cet event est complet !');
            }
       }
       catch(\Exception $e){
            return redirect('event');
       }
    }

    public function unregisterEvent($id){
        try{
            $event = ModelsEvent::findOrFail($id);
            $event->unregisterEvent(Auth::user()->id);
            return redirect('event')->with('successMsg', 'Vous êtes désinscrit de cet event !');
        }
        catch(\Exception $e){
            return redirect('event')->with('errorMsg', 'Erreur lors de la désinscription de l\'event !');
        }
    }
}
