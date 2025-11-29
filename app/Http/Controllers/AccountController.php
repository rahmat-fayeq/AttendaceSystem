<?php
namespace App\Http\Controllers;

use App\Models\User;
use Devrabiul\ToastMagic\Facades\ToastMagic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.account.index',[
            'users' => User::all(),
        ]);
    }

     /**
     * Show the form for creating the specified resource.
     */
    public function create()
    {
        return view('pages.account.create');
    }

    
     /**
     * store the form for creating the specified resource.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required','string','email','max:255',Rule::unique(User::class)],
            'password' => ['required', 'string', Password::default(), 'confirmed'], 
            'active' => ['required','in:0,1']
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'active' =>(bool)$validated['active']
        ]);

        ToastMagic::success(__('app.success'));

        return redirect()->route('accounts.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('pages.account.edit',[
            'user' => User::where('id',$id)->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOr($id);

        $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes','email','max:255',
                 Rule::unique('users', 'email')->ignore($user->id, 'id')
            ],
            'password' => ['sometimes', 'nullable', 'string', Password::default(), 'confirmed'],
            'active' => ['sometimes','required','in:0,1']
        ]);

        try {
            DB::transaction(function () use ($request, $user) {
                $data = [];

                if ($request->filled('name')) {
                    $data['name'] = $request->name;
                }

                if ($request->filled('email')) {
                    $data['email'] = $request->email;
                }

                if ($request->filled('password')) {
                    $data['password'] = Hash::make($request->password);
                }

                if ($request->filled('active')) {
                    $data['active'] = (bool)$request->active;
                }

                if (!empty($data)) {
                    $user->update($data);
                }
            });

            ToastMagic::success(__('app.info'));
            return redirect()->route('accounts.index');

        } catch (\Exception $e) {
            ToastMagic::error(__('app.warning'));
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::where('id',$id)->delete();
        ToastMagic::warning(__('app.warning'));
        return redirect()->back();
    }
}
