<!DOCTYPE html>
<html lang="en" class="dark">

<?php
echo view("Views/layout/head");
?>

<body class="dark:bg-slate-600">
    <div class="main-content">
        <!-- component -->
        <div class="flex h-screen">
            <!-- Left Pane -->
            <div class="hidden lg:flex items-center justify-center flex-1 bg-white text-black">
                <div class="max-w-md text-center">
                    <img src="assets/logo.png" alt="image description">
                </div>
            </div>
            <!-- Right Pane -->
            <div class="w-full dark:bg-gray-800 lg:w-1/2 flex items-center justify-center">
                <div class="max-w-md w-full p-6">
                    <h1 class="text-3xl font-semibold mb-6 text-white text-center">Login</h1>
                    <h1 class="text-sm font-semibold mb-6 text-blue-300 text-center">Sistem Penilaian Karakter Siswa Siswi SMK NEGRI 18 TANGERANG SELATAN </h1>
                    <div class="mt-4 flex flex-col lg:flex-row items-center justify-between">
                    </div>
                    <form action="/login" method="POST" class="space-y-4">
                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Username</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-sm text-slate-900 bg-slate-200 border border-e-0 border-slate-300 rounded-s-md dark:bg-slate-600 dark:text-slate-400 dark:border-slate-600">
                                    <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z" />
                                    </svg>
                                </span>
                                <input type="text" id="username" name="username" class="rounded-none rounded-e-lg bg-slate-50 border border-slate-300 text-slate-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5  dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="user / email.com">
                            </div>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Password</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-sm text-slate-900 bg-slate-200 border border-e-0 border-slate-300 rounded-s-md dark:bg-slate-600 dark:text-slate-400 dark:border-slate-600">
                                    <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M10 12v1h4v-1m4 7H6a1 1 0 0 1-1-1V9h14v9a1 1 0 0 1-1 1ZM4 5h16a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                                    </svg>
                                </span>
                                <input type="password" id="password" name="password" class="rounded-none rounded-e-lg bg-slate-50 border border-slate-300 text-slate-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5  dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Password">
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="w-full bg-black text-white p-2 rounded-md hover:bg-slate-500  focus:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition-colors duration-300">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>