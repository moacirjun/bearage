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
import axios from 'axios';

const token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1ODc0NTE5MDQsImV4cCI6MTAwMDE1ODc0NTE5MDMsInJvbGVzIjpbIlJPTEVfVVNFUiJdLCJlbWFpbCI6Im1vYWNpcmp1bmlyLmVsZXRyb0BnbWFpbC5jb20ifQ.hHRyitIH5B5ERy5L_Apcg4Z2hG7MhzGYhusSIaP4oIg_xNb9_LOAO88b5k2CfHzfX52j_ZyKcgJG_640S2TKo2qCyduZbWgjG9zIm8CGYSg9k9FavgT5l5SjiWSD6frZqsIjfN0cg0c80khQk-H4f5IFQkHB4T6RELkchSW2mQp7XyZyC5BUVnq33AIREVOGrsM9e7_M6YJcqvGgdo-rCljDV5vCrbFCqIgzwY37w6gyNCseorWhQ3Mho2xOekXI2Je-87E6ryjbnefOOPZ2-_UpPlb_RjP60v_O8bH4sAGeiizKWP4eH72RvyS5piVhQow_E-CIMJSjrCjbFJTtu_WBQhov77SY5pEhlODmeu4sVELg4WQSsTP5V9z872KIiar-1nR9xRypBC3i8ZtAs1p_KF7CdaP2NKKBbkrP0WNmlg75r_0wC2RNmpNU3ANN-7MNoR-QQ1AejoQCn1ZjIFGSvW2PIKBpx8UxxkU3Rn5gidLTpFHCSwP757TElOMs1OL7GgV6CvqWm4ROb0W6Om_uy49-r5zd-jDHqIoAUSdzJUYgVkF3YNoW65TWG7sfXtxqlxt0QJzQGBP1W8WMFhFxYum4qzkvctk1nMIeZq8NQFpPp-6-Jj9Ob7zh7mnYTFXxbx9HDA7ml8EEjLgRCH8HTwCYc5ziSbopl43DMEM';

console.axios = axios.create({
    // baseURL: 'localhost',
    headers: {'Authorization': 'Bearer ' + token}

});

ReactDOM.render(<Router><Products /></Router>, document.getElementById('root'));
