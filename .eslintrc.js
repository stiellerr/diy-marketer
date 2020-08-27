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
    parserOptions: {
        ecmaFeatures: {
            jsx: true
        },
        ecmaVersion: 11,
        sourceType: "module"
    },
    plugins: ["react"],
    rules: {
        "no-console": "warn",
        //
        "react/react-in-jsx-scope": "off",
        //
        "react/display-name": "off",
        "react/prop-types": "off",
        "no-undef": "warn"
    }
};
