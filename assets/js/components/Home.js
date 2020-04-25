import React from 'react';
import ProductSearch from './ProductSearch';

class Home extends React.Component
{
    constructor() {
        super();

        this.state = {
            search: '',
            products: {
                isFetching: false,
                items: [],
            },
        };

        this.setIsFetching = this.setIsFetching.bind(this);
        this.onSearchTextChange = this.onSearchTextChange.bind(this);
        this.setItems = this.setItems.bind(this);
    }

    setIsFetching(fetcing) {
        this.setState({
            products: {...this.state.products, isFetching: fetcing}
        });
    }

    onSearchTextChange(text) {
        this.setState({
            products: {...this.state.products},
            search: text
        });
    }

    setItems(items) {
        this.setState({
            products: {
                ...this.state.products,
                items
            }
        });
    }

    render() {
        return (
            <React.Fragment>
                <h2>Home</h2>
                <ProductSearch
                    isFetching={this.setIsFetching}
                    onSearchTextChange={this.onSearchTextChange}
                    setItems={this.setItems}
                    searchText={this.state.search}
                />
            </React.Fragment>
        );
    }
}

export default Home;
