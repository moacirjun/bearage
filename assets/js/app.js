/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';
import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router } from 'react-router-dom';
import Products from './components/Products';
import loadAxiosDefaultConfig from './config/axios';
import CssBaseline from '@material-ui/core/CssBaseline';

loadAxiosDefaultConfig();

ReactDOM.render(
    <React.Fragment>
        <CssBaseline />
        <Router>
            <Products />
        </Router>
    </React.Fragment>,
    document.getElementById('root')
);
