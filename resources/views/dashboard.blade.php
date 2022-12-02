@extends('layout')
@section('content')


    <div class="wrapper bg-white">
        @if (session('notAllowed'))
        <div class="alert alert-danger">
            {{session('notAllowed')}}
        </div>
        @endif

        @if (session('successAdd'))
       <script>
         Swal.fire(
        'Semangat ya!',
        'Berhasil menambahkan data ToDo!',)
         </script>
        @endif
        
        @if (session('successUpdate'))
        <script>
          Swal.fire(
         'Wow hebat!',
         'Data todo berhasil diperbarui!',)
          </script>
        @endif

            
        @if (session('deleted'))
        <script>
          Swal.fire(
         'Success',
         'Berhasil menghapus data ToDo!',)
          </script>
        @endif

        @if (session('done'))
        <script>
          Swal.fire(
         'Wih keren!',
         'Todo telah selesai dikerjakan!',)
          </script>
        @endif


        <div class="d-flex align-items-start justify-content-between">
            <div class="d-flex flex-column">
                <div class="h5">My Todo's</div>
                <p class="text-muted text-justify">
                    Here's a list of activities you have to do
                </p>
                <br>
                <span>
                    <a href="/create" class="text-success">Create</a>  <a href="">Complated</a>
                </span>
            </div>
            <div class="info btn ml-md-4 ml-0">
                <span class="fas fa-info" title="Info"></span>
            </div>
        </div>
        <div class="work border-bottom pt-3">
            <div class="d-flex align-items-center py-2 mt-1">
                <div>
                    <span class="text-muted fas fa-comment btn"></span>
                </div>
                <div class="text-muted">2 todos</div>
                <button class="ml-auto btn bg-white text-muted fas fa-angle-down" type="button" data-toggle="collapse"
                    data-target="#comments" aria-expanded="false" aria-controls="comments"></button>
            </div>
        </div>
        <div id="comments" class="mt-1">
            {{-- looping data-data dari compact 'todo' agar dapat ditampilkan perbaris datanya --}}
         @foreach ($todos as $todo)
            <div class="comment d-flex align-items-start justify-content-between">
                <div class="mr-2">
                    {{-- check kalau statusnya 1 (complate) maka, yang ditampilkan icon biasa gabisa diklik --}}
                    @if ($todo['status'] == 1)
                        <span class="fa-solid fa-bookmark text-secondary btn"></span>
                    {{-- kalau statusnya 0 maka, icon checklist muncul yang bisa diklik buat update ke complated --}}
                    @else
                        <form method="POST" action="{{route('update-complated', $todo['id'])}}">
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="fas fa-circle-check text-primary btn "></button>
                        </form>
                    @endif
                </div>
                <div class="d-flex flex-column w-75">
                    {{-- menampilkan data dinamis atau data yang diambil dari db pada blade harus menggunakan {{}} --}}
                    {{-- path yang {id} dikirim data dinamis (data dari db) makanya disitu dipake {{}} --}}
                    <a href ="/edit/{{$todo['id']}}" class="text-justify">
                        {{$todo['title']}}
                    </a>

                    <p>{{ $todo['description'] }}</p>
                    {{-- konsep ternary : if column status baris ini isinya 1 bakal munculin teks 'Complated' selain dari 
                    itu akan menampilkan teks 'On-Process' --}}

                    <p class="text-muted">{{ $todo['status'] == 1? 'Complated' : 'On-Process'}} 
                        {{-- Carbon itu package dari laravel untuk mengelola yang berhubungan dengan date. Tadinya 
                        value column date di db kan bentuknya format 2022-11-22 nah kita pengen ubah bentuk formatnya
                        jad 22 November, 2022 --}}
                        <span class="date">
                            {{-- check kalau statusnya 1 (complate) maka, yang ditampilkan kapan dia selesai diambil dari done_time --}}
                            @if ($todo['status'] == 1) 
                                selesai pada : {{
                                    \Carbon\Carbon::parse($todo->done_time)->format('j F, Y') }}
                            {{--  kalau statusnya 0 maka, yang akan ditampilkan kapan dia dibuat (data dari column date yang diisi dari input pilih tanggal difitur create)  --}}
                            @else 
                                target selesai : {{\Carbon\Carbon::parse($todo->date)->format('j F, Y')}}
                            @endif
                            </span>
                    </p>
                </div>
                <div class="ml-auto">
                    <form method="POST" action="{{route('delete', $todo['id'])}}">
                        {{-- Apabila fiturnya berkaitan dengan modifikasi database, maka gunakan form  --}}
                        @csrf
                        @method('DELETE')
                        <a href="/delete/{{$todo->id}}" class="fas fa-arrow-right btn"></a>
                        {{-- <button type="submit" class="fa-solid fa-trash-can text-danger btn fa-lg"></button> --}}
                    </form>
                </div>
            </div>
         @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
@endsection