import React from 'react';

const ProductList = (props) => {
    return (
        props.isFetching
            ? <h4>Procurando...</h4>
            : <ul>
                {props.products.map(item => (
                    <li
                        onClick={() => (props.onProductClick(item))}
                        key={item.code}
                    >
                        {item.name} [R$ {item.salePrice}]
                    </li>
                ))}
            </ul>
    );
};

export default ProductList;
