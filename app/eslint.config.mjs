import js from '@eslint/js';
import globals from 'globals';
import pluginReact from 'eslint-plugin-react';
import pluginPrettier from 'eslint-plugin-prettier';
import babelParser from '@babel/eslint-parser';

export default [
  {
    files: ['assets/**/*.js', 'assets/**/*.jsx'],
    languageOptions: {
      globals: {
        ...globals.browser,
        ...globals.node,
        es2021: true,
      },
      parser: babelParser,
      parserOptions: {
        ecmaVersion: 2020,
        sourceType: 'module',
        ecmaFeatures: {
          jsx: true,
        },
        requireConfigFile: false,
        babelOptions: {
          plugins: ['@babel/plugin-syntax-jsx'],
        },
      },
    },
    plugins: {
      react: pluginReact,
      prettier: pluginPrettier,
    },
    rules: {
      // Prettier
      'prettier/prettier': [
        'error',
        {
          printWidth: 120,
          tabWidth: 4,
          useTabs: false,
          semi: true,
          singleQuote: true,
          trailingComma: 'all',
          bracketSpacing: true,
          arrowParens: 'always',
        },
      ],

      'no-unused-vars': 'warn',
      'no-undef': 'error',
      'no-debugger': 'error',
      'prefer-const': 'warn',
      'no-unneeded-ternary': 'warn',
      'no-nested-ternary': 'warn',
      'prefer-arrow-callback': 'warn',
      'arrow-spacing': ['warn', { before: true, after: true }],
      eqeqeq: ['error', 'always'],
      'no-shadow': 'warn',
      'consistent-return': 'error',
      'no-param-reassign': ['error', { props: true }],
      'no-empty-function': 'warn',
      'no-useless-catch': 'warn',
      'object-shorthand': ['warn', 'always'],
      curly: ['error', 'all'],

      // React
      'react/jsx-uses-react': 'off',
      'react/react-in-jsx-scope': 'off',
      'react/jsx-uses-vars': 'error',
      'react/prop-types': 'off',
    },
  },

  {
    ...js.configs.recommended,
  },
];
