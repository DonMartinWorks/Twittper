<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => 'inline-flex items-center px-4 py-2 bg-cyan-800 dark:bg-cyan-400 border border-transparent rounded-md
                        font-semibold text-xs text-white dark:text-slate-800 uppercase tracking-widest hover:bg-cyan-700
                        dark:hover:bg-teal-400 focus:bg-cyan-700 dark:focus:bg-cyan-500 active:bg-cyan-900 dark:active-cyan-300
                        focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-cyan-800
                        transtition ease-in-out duration-150',
    ]) }}>
    {{ $slot }}
</button>
