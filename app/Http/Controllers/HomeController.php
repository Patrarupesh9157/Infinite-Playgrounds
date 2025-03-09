<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Concept;
use App\Models\Contact;
use App\Models\Fabric;
use App\Models\Game;
use App\Models\GameLike;
use App\Models\GameReview;
use App\Models\Panna;
use App\Models\Product;
use App\Models\TechnicallyConcept;
use App\Models\UseIn;
use App\Models\Yarn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        return view('home');
    }

    /**
     * Display the shop page.
     */
    public function shop()
    {
        $games = Game::paginate(12);
        return view('shop', compact('games'));
    }

    /**
     * Display the product details.
     */
    public function game($id)
    {
        $game = Game::withCount('likes')->findOrFail($id);
        $reviews = GameReview::where('game_id', $id)
            ->with('user')
            ->latest()
            ->get();
        
        $userHasLiked = false;
        if (auth()->check()) {
            $userHasLiked = GameLike::where('game_id', $id)
                ->where('user_id', auth()->id())
                ->exists();
        }

        $averageRating = $reviews->avg('rating');
        
        return view('game', compact('game', 'reviews', 'userHasLiked', 'averageRating'));
    }

    public function toggleLike($id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Please login to like games'], 401);
        }

        $like = GameLike::where('game_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if ($like) {
            $like->delete();
            $action = 'unliked';
        } else {
            GameLike::create([
                'game_id' => $id,
                'user_id' => auth()->id()
            ]);
            $action = 'liked';
        }

        $likesCount = GameLike::where('game_id', $id)->count();

        return response()->json([
            'action' => $action,
            'likes_count' => $likesCount
        ]);
    }

    public function storeReview(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to review games');
        }

        $request->validate([
            'review' => 'required|string|min:10',
            'rating' => 'required|integer|between:1,5'
        ]);

        GameReview::create([
            'game_id' => $id,
            'user_id' => auth()->id(),
            'comment' => $request->review,
            'rating' => $request->rating
        ]);

        return back()->with('success', 'Review submitted successfully!');
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        return view('contact');
    }

    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        // Optional: Send email notification
        // Mail::to('admin@example.com')->send(new ContactFormSubmitted($validated));

        return back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }
    /**
     * Display search results.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        return view('search', compact('query'));
    }

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Account created successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

}
