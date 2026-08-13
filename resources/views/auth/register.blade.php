@extends('layouts.app')

@section('title', 'Sign Up - AI Resume Builder')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8 bg-slate-950">
    <div class="max-w-sm w-full mx-auto space-y-8 bg-slate-900/60 backdrop-blur-xl border border-slate-800 p-6 sm:p-8 rounded-2xl shadow-2xl shadow-indigo-500/5">
        <div>
            <div class="flex justify-center">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/25">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold tracking-tight text-white font-sans">
                Create Account
            </h2>
            <p class="mt-2 text-center text-sm text-slate-400">
                Or
                <a href="{{ route('login') }}" class="font-medium text-indigo-400 hover:text-indigo-300 transition-colors">
                    sign in to your existing account
                </a>
            </p>
        </div>

        @if ($errors->any())
            <div class="rounded-lg bg-red-950/50 border border-red-900/50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-300">
                            There were errors with your submission
                        </h3>
                        <div class="mt-2 text-sm text-red-400">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="rounded-md space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-300 mb-1">Full Name</label>
                    <input id="name" name="name" type="text" autocomplete="name" required 
                           class="appearance-none relative block w-full px-3 py-2.5 border border-slate-800 placeholder-slate-500 text-slate-100 rounded-xl bg-slate-950 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm transition-all" 
                           placeholder="John Doe" value="{{ old('name') }}">
                </div>
                <div>
                    <label for="email-address" class="block text-sm font-medium text-slate-300 mb-1">Email address</label>
                    <input id="email-address" name="email" type="email" autocomplete="email" required 
                           class="appearance-none relative block w-full px-3 py-2.5 border border-slate-800 placeholder-slate-500 text-slate-100 rounded-xl bg-slate-950 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm transition-all" 
                           placeholder="you@example.com" value="{{ old('email') }}">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-300 mb-1">Password</label>
                    <input id="password" name="password" type="password" required 
                           class="appearance-none relative block w-full px-3 py-2.5 border border-slate-800 placeholder-slate-500 text-slate-100 rounded-xl bg-slate-950 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm transition-all" 
                           placeholder="••••••••">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-1">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                           class="appearance-none relative block w-full px-3 py-2.5 border border-slate-800 placeholder-slate-500 text-slate-100 rounded-xl bg-slate-950 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm transition-all" 
                           placeholder="••••••••">
                </div>
            </div>

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg shadow-indigo-500/25 active:scale-95 transition-all">
                    Sign Up
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
