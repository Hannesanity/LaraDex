import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: { 
        colors: {
            normal: '#d1ccc0',
            fire: '#fa6c5e',
            water: '#4a90e2',
            electric: '#fbd34d',
            grass: '#78c850',
            ice: '#87ceeb',
            fighting: '#c05640',
            poison: '#aa67cc',
            ground: '#d1a054',
            flying: '#a4b4e6',
            psychic: '#fa92b2',
            bug: '#a9b91f',
            rock: '#c5b27b',
            ghost: '#7d73cf',
            dragon: '#5a5ce7',
            dark: '#756a5b',
            steel: '#b0b6c5',
            fairy: '#f2a3d9',
            transparent: 'transparent',
            white: '#fff',
            black: '#000'
        },
        extend: {
            height:{
                '9/10': '90%',
            },
            
            
            fontFamily: {
                sans: ['"Press Start 2P"', 'cursive'],
                
            },
        },
    },
    plugins: [],
};
