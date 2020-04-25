import React from 'react';
import { Link } from 'react-router-dom';

const Nav = () => (
    <ul>
        <li>
            <Link to="/">Home</Link>
        </li>
        <li>
            <Link to="/products">Produtos</Link>
        </li>
        <li>
            <Link to="/orders">Vendas</Link>
        </li>
    </ul>
);

export default Nav;
