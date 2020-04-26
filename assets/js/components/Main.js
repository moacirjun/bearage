import React from 'react';
import { Switch, Route } from 'react-router-dom';
import Nav from './Nav';
import Orders from './Orders';
import Products from './Products';
import AddProducts from './AddProduct';
import Home from './Home';

const Main = () => (
    <React.Fragment>
        <Nav />
        <h1>Bearage</h1>
        <Switch>
            <Route path="/" exact><Home /></Route>
            <Route path="/products"><Products /></Route>
            <Route path="/orders"><Orders /></Route>
            <Route path="/products-create"><AddProducts /></Route>
        </Switch>
    </React.Fragment>
);

export default Main;