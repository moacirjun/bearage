import React from 'react';
import { Switch, Route } from 'react-router-dom';
import Nav from './Nav';
import Orders from './Orders';
import Products from './Products';
import AddProducts from './AddProduct';
import Home from './Home';
import Paper from '@material-ui/core/Paper';
import Container from '@material-ui/core/Container';

const Main = () => (
    <React.Fragment>
        <Nav />
        <Container maxWidth="sm">
            <main>
                <Switch>
                    <Route path="/" exact><Home /></Route>
                    <Route path="/products"><Products /></Route>
                    <Route path="/orders"><Orders /></Route>
                    <Route path="/products-create"><AddProducts /></Route>
                </Switch>
            </main>
        </Container>
    </React.Fragment>
);

export default Main;
