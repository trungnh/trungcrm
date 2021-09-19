// Global constant.
if (!window.hasOwnProperty('global')) {
    window.global = Object.create(null);
}

// Data exists in every pages.
export const global = window.global;

// Data share between some modules.
export const storage = Object.create(null);
