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
        // Get top 5 highest-rated games with at least one review
        $topRatedGames = Game::withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->with(['reviews' => function($query) {
                $query->with('user')->orderBy('rating', 'desc')->limit(1);
            }])
            ->having('reviews_count', '>=', 1)
            ->orderByDesc('reviews_avg_rating')
            ->take(5)
            ->get();

        return view('home', compact('topRatedGames'));
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
    
    /**
     * Display the game in full screen play mode.
     */
    public function playGame($id)
    {
        $game = Game::findOrFail($id);
        
        // Get related games for recommendations
        $relatedGames = Game::where('id', '!=', $id)
            ->inRandomOrder()
            ->take(3)
            ->get();
            
        return view('play', compact('game', 'relatedGames'));
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


    public function getAdminCountData()
    {
        // Get total games count
        $gamesCount = Game::count();

        // Get total likes count
        $likesCount = GameLike::count();

        // Get total reviews count
        $reviewsCount = GameReview::count();

        // You can also add more specific counts if needed
        // $usersCount = User::count();
        // $contactsCount = Contact::count();

        return response()->json([
            'games' => $gamesCount,
            'likes' => $likesCount,
            'reviews' => $reviewsCount,
            // 'users' => $usersCount,
            // 'contacts' => $contactsCount,
        ]);
    }

}
