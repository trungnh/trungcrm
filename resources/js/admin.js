/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import dispatcher from './pages/admin/dispatcher';
import app from './system/bootstrap'

/**
 * Create app for admin
 */
app(dispatcher);
