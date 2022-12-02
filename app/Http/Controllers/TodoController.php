<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function reglog()
    // {
    //     return view('reglog');
    // }

    public function logreg() 
    {
        return view('logreg');
    }

    public function index()
    { 
        //ambil data dari table todos dengan model Todo
        // all() fungsinya untuk mengambil semua data di table
        $todos = Todo::where('user_id', '=', Auth::user()->id)->get();
        // kirim data yang sudah diambil ke file blade /file yang menampilkan halaman
        // kirim melalui compact ()
        // isi compact sesuaikan dengan nama variable
        return view('dashboard', compact('todos'));
    }

    public function complated() {
        return view ('dashboard.complated');
    }

    public function updateComplated($id) {
        // cari data yang mau diubah status 'complated' dan column 'done_time" yang tadinya null diisi dengan tanggal sekarang
        // karena status boolean, 0 untuk status on-progress dan 1 untuk complated
        Todo::where('id', '=', $id)->update([
            'status' => 1,
            'done_time' => \Carbon\Carbon::now(),
        ]);
        //apabila berhasil, akan dikembalikan ke halaman awal dengan pemberitahuan
        return redirect()->back()->with('done', 'Todo telah selesai dikerjakan!');
    }
 
    public function registerAccount(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'email' => 'required|email:dns',
            'username' => 'required|min:4|max:8',
            'password' => 'required|min:4',
            'name' => 'required|min:3',
        ]);
        //input data ke db
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/logreg')->with('successAdd', 'Berhasil menambahkan akun! 
        Silahkan login');
    }

    public function Auth(Request $request)
    {
       $request->validate([
        'username' => 'required|exists:users,username',
        'password' => "required",
       ], 
       [ 
        'username.exists' => 'username ini belum tersedia',
        'username.required' => 'username harus diisi',
        'password.required' => 'password harus diisi',
    
       ]);

       $user = $request->only('username', 'password');
       if (Auth::attempt($user)) {
        return redirect()->route('todo.index');
       }
       else {
        return redirect()->back()->with('notAllowed', 'Gagal login, silahkan cek dan coba lagi');
       }
    }

    public function logout() {
        // menghapus history login
        Auth::logout();
        // mengarahkan ke halaman login lain
        return redirect('/logreg');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //menyimpan data ke database
        //tes koneksi blade dengan controller
        // dd(request->all());

        //validasi data
        $request->validate([
            'title' => 'required|min:3',
            'date' => 'required',
            'description' => 'required|min:5',
        ]);

        // kirim data ke database table todos dengan model todo
        // '' = nama colmn di table db
        // $request-> = value attribute nama pada input
        // kenapa yang dikirim 5 data? karena table pada db todos membutuhkan 6 column input
        // salah satunya column 'done_time' yang tipennya nullable, karena nullable jadi ga perlu kirim nilai
        // 'user_id' untuk memberitahu data todo ini milik siapa, diambil melalui fitur Auth
        // 'status' tipenya boolean, 0 = belum dikerjakan, 1 = sudah dikerjakan (todonya)

        Todo::create([
            'title' => $request->title,
            'date' => $request->date,
            'description' => $request->description,
            'done_time' => $request->date,
            'status' => 0,
            'user_id' => Auth::user()->id,
        ]);

        //kalau berhasil diarahin ke halaman todo awal dengan pemberitahuan
        return redirect('/todo')->with('successAdd', 'Berhasil menambahkan data Todo!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */

  
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo, $id)
    {
        // menampilkan halaman input form edit
        // mengambil data satu baris ketika column id pada baris tersebut sama dengan id dari parameter route

        $todo = Todo::where('id', $id)->first();
        //kirim data yang diambil ke file blade dengan compact

        return view('edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required|min:3',
            'date' => 'required',
            'description' => 'required|min:5',
        ]);
        //cari baris data yang punya id sama dengan data id yang dikirim ke parameter route
        //kalau udah ketemu, update column-column datanya
        Todo::where('id', $id)->update([
            'title' => $request->title,
            'date' => $request->date,
            'description' => $request->description,
            'status' => 0,
            'user_id' => Auth::user()->id,
        ]);
        //kalau berhasil halaman bakal di redirect ulang ke halaman list todo dengan pemberitahuan pesan

        return redirect('/todo')->with('successUpdate', 'Data todo berhasil diperbarui!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        // menghapus data di database
        // filter atau cari data yang mau dihapus, baru dijalankan perintah hapusnya
        Todo::where('id', '=', $id)-> delete();
        // jika sudah balik lagi ke halaman awalnya dengan pemberitahuan
        return redirect()->back()->with('deleted', 'Berhasil menghapus data ToDo!');

        // $todo = Todo::findOrFail($id);
        // $todo->delete();
        // return redirect('/todo')->with('success-delete');
    }

 


}
