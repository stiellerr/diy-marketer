module.exports = {
    env: {
        browser: true,
        es6: true,
        node: true
    },
    extends: ["eslint:recommended", "plugin:react/recommended", "prettier"],
    globals: {
        Atomics: "readonly",
        SharedArrayBuffer: "readonly",
        wp: "readonly"
    },
    // new 23/11/2020
    parser: "babel-eslint",
    //
    parserOptions: {
        ecmaFeatures: {
            jsx: true
        },
        ecmaVersion: 11,
        sourceType: "module"
    },
    plugins: ["react", "jsx-a11y"],
    rules: {
        "no-console": "warn",
        "no-unused-vars": "warn",
        "no-undef": "warn",
        //
        "react/react-in-jsx-scope": "off",
        //
        "react/display-name": "off",
        "react/prop-types": "off"
    }
};
