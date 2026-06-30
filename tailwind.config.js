import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Définition des couleurs du projet
                'cnss-blue': '#003399', // Bleu pour Navbar, Footer et Boutons d'action
                'cnss-red': '#E30613',  // Rouge pour bouton Supprimer
                'cnss-green': '#00A651', // Optionnel (pour le succès, comme dans le logo)
            },
        },
    },

    plugins: [forms],
};