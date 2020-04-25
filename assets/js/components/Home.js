import React from 'react';
import { Switch, Route } from 'react-router-dom';
import Nav from './Nav';
import Orders from './Orders';
import Products from './Products';

const Home = () => (
    <React.Fragment>
        <Nav />
        <h1>Bearage</h1>
        <Switch>
            <Route path="/" exact><h2>Home</h2></Route>
            <Route path="/products"><Products /></Route>
            <Route path="/orders"><Orders /></Route>
        </Switch>
    </React.Fragment>
);

export default Home;
