<?php

namespace App\Http\Controllers;

use App\Models\Line;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total = Line::sum('total');
        $discharge = Line::where('total', '<', 0)->sum('total');
        $lines = Line::count(['id']);

        $paginatedLines = Line::with('user:id,name')->latest()->paginate(5);

        $grouped = Line::groupBy('type')->select('type', DB::raw('SUM(total) as total'))->get();

        return view('home', compact('total', 'discharge', 'lines', 'paginatedLines', 'grouped'));
    }

    public function save(Request $request)
    {
        $line = Line::create($request->all());

        $request->user()->lines()->save($line);

        return redirect()->route('home');
    }

    public function destroy($id)
    {
        $line = Line::findOrFail($id);

        $line->delete();

        return back();
    }
}
