/**
 * Get current env.
 * @returns {string}
 */
export function env() {
    return process.env.NODE_ENV;
}

export function isProduction() {
    return env() === 'production';
}
