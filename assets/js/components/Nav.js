import React from 'react';
import { Link } from 'react-router-dom';
import * as Material from '@material-ui/core';
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
            <Material.List>
                {pages.map(page => (
                    <Material.ListItem button key={page.text} component={Link} to={page.path} exact={page.exact}>
                        <Material.ListItemText primary={page.text}/>
                    </Material.ListItem>
                ))}
            </Material.List>
        </nav>
    );

    return (
        <header>
            <Material.AppBar position="static">
                <Material.Toolbar>
                    <Material.IconButton
                        edge="start"
                        color="inherit"
                        aria-label="menu"
                        onClick={toggleDrawer(true)}
                    >
                        <MenuIcon />
                    </Material.IconButton>
                    <Material.Typography variant="h6">
                        Bearage
                    </Material.Typography>
                </Material.Toolbar>
            </Material.AppBar>
            <Material.SwipeableDrawer
                anchor="left"
                open={state.isShowing}
                onClose={toggleDrawer(false)}
                onOpen={toggleDrawer(true)}
            >
                {list()}
            </Material.SwipeableDrawer>
        </header>
    );
};

export default Nav;
