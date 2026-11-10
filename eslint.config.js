import js from "@eslint/js";
import globals from "globals";

export default [
    js.configs.recommended,
    {
        languageOptions: {
            ecmaVersion: "latest",
            sourceType: "module",
            globals: {
                ...globals.browser,
                ...globals.node,
                $: "readonly",
                jQuery: "readonly",
                Swiper: "readonly",
                Swal: "readonly",
                bootstrap: "readonly",
            },
        },
        rules: {
            "no-unused-vars": ["warn", { "argsIgnorePattern": "^_" }],
            "no-undef": "warn",
            "no-redeclare": "warn",
            "no-console": "off",
        },
    },
    {
        ignores: [
            "**/node_modules/**",
            "**/vendor/**",
            "public/js/**/*.min.js",
            "public/build/**",
            "storage/**",
        ],
    },
];
