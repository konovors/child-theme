module.exports = {
  // overrides: [
  //   {
  //     files: ['assets/styles/**/*.scss'],
  //     customSyntax: 'postcss-scss',
  //   },
  // ],
  extends: 'stylelint-config-standard-scss',
  ignoreFiles: ['**/*.js', 'dist/**/*.css'],
  ignore: ['no-descending-specificity', 'selectors-within-list'],
  rules: {
    'scss/dollar-variable-pattern': null,
    'selector-class-pattern': null,
    'no-descending-specificity': null,
    'no-empty-source': null,
    'string-quotes': 'double',
    'value-keyword-case': [
      'lower',
      {
        ignoreKeywords: ['BlinkMacSystemFont'],
        ignoreProperties: ['$main_font_family', '$font-family-base'],
      },
    ],
    'no-invalid-position-at-import-rule': null,
    'at-rule-no-unknown': [
      true,
      {
        ignoreAtRules: [
          'use',
          'extend',
          'at-root',
          'debug',
          'warn',
          'error',
          'if',
          'else',
          'for',
          'each',
          'while',
          'mixin',
          'include',
          'content',
          'return',
          'function',
          'tailwind',
          'apply',
          'responsive',
          'variants',
          'screen',
        ],
      },
    ],
  },
};
