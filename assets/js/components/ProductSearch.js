import React from 'react';
import axios from 'axios';
import { FormControl, InputLabel, Input, InputAdornment } from '@material-ui/core';
import SearchIcon from '@material-ui/icons/Search';
class ProductSearch extends React.Component
{
    constructor(props) {
        super(props);

        this.onChangeHandle = this.onChangeHandle.bind(this);
        this.fetchProducts = this.fetchProducts.bind(this);
        this.fetchPrincipalProducts = this.fetchPrincipalProducts.bind(this);
    }

    componentDidMount() {
        this.fetchPrincipalProducts();
    }

    fetchPrincipalProducts() {
        this.fetchProducts('');
    }

    onChangeHandle(event) {
        const newValue = event.target.value;

        this.props.onSearchTextChange(newValue);
        this.fetchProducts(newValue);
    }

    fetchProducts(searchText) {
        this.props.isFetching(true);

        const uri = searchText
            ? `api/products?search=${searchText}`
            : 'api/products';

        axios.get(uri)
            .then(response => {
                this.props.isFetching(false);

                if (response.status !== 200) {
                    return;
                }

                const { data: { items } } = response;

                this.props.setItems(items);
            })
            .catch(error => {
                this.props.isFetching(false);
                console.error(error);
            });
    }

    render() {
        return (
            <FormControl>
                <Input
                    id="standard-adornment-search"
                    type="text"
                    placeholder="Pesquise por nome, cód..."
                    size="small"
                    value={this.props.searchText}
                    onChange={this.onChangeHandle}
                    endAdornment={
                        <InputAdornment position="end">
                            <SearchIcon />
                        </InputAdornment>
                    }
                />
            </FormControl>
        );
    }
}

export default ProductSearch;
