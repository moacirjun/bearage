import React from 'react';
import { Link } from 'react-router-dom';
import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import ListItemText from '@material-ui/core/ListItemText';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
import SwipeableDrawer from '@material-ui/core/SwipeableDrawer';
import IconButton from '@material-ui/core/IconButton';
import MenuIcon from '@material-ui/icons/Menu';

const Nav = () => {
    const [state, setState] = React.useState({
        isShowing: false,
    });

    const toggleDrawer = show => event => {
        if (event && event.type === 'keydown' && (event.key === 'Tab' || event.key === 'Shift')) {
            return;
        }

        setState({isShowing: show});
    };

    const pages = [
        {
            text: 'Home',
            path: '/',
            exact: 'true',
        }, {
            text: 'Produtos',
            path: '/products',
            exact: 'false',
        }, {
            text: 'Vendas',
            path: '/orders',
            exact: 'false',
        }
    ];

    const list = () => (
        <nav onClick={toggleDrawer(false)} onKeyDown={toggleDrawer(false)}>
            <List>
                {pages.map(page => (
                    <ListItem button key={page.text} component={Link} to={page.path} exact={page.exact}>
                        <ListItemText primary={page.text}/>
                    </ListItem>
                ))}
            </List>
        </nav>
    );

    return (
        <header>
            <AppBar position="static">
                <Toolbar>
                    <IconButton
                        edge="start"
                        color="inherit"
                        aria-label="menu"
                        onClick={toggleDrawer(true)}
                    >
                        <MenuIcon />
                    </IconButton>
                    <Typography variant="h6">
                        Bearage
                    </Typography>
                </Toolbar>
            </AppBar>
            <SwipeableDrawer
                anchor="left"
                open={state.isShowing}
                onClose={toggleDrawer(false)}
                onOpen={toggleDrawer(true)}
            >
                {list()}
            </SwipeableDrawer>
        </header>
    );
};

export default Nav;
