import { useNavigate, useParams } from 'react-router-dom';
import Breadcrumb from '../../components/Navigation/Breadcrumb';
import PageHeader from '../../components/Layout/PageHeader';
import React, { useEffect, useState } from 'react';
import restApiClient from '../../../shared/api/RestApiClient';
import CategoryForm from './Partials/CategoryForm';
import { createApiConfig } from '@/shared/api/ApiConfig';
import {useApi} from "@/admin/hooks/useApi";


const CategoryFormPage = ({}) => {
    const params = useParams();
    const navigate = useNavigate();
    const {executeRequest, isLoading} = useApi();

    const [selectedCategory, setSelectedCategory] = useState(null);
    const [categoryData, setCategoryData] = useState({});

    useEffect(() => {
        (async () => {
            const url = params.id ? `${params.id}` : '';
            const config = createApiConfig(`category/form-data/${url}`, 'GET', true);
            const {data, errors} = await executeRequest(config);
            if (!errors) {
                setCategoryData(data);
            }
        })();
    }, [params.id]);

    const onSubmit = async values => {
        try {
            const config = params.id
                ? createApiConfig(`category/${params.id}/update`, 'PUT', true)
                : createApiConfig('category/create', 'POST', true);

            const response = await restApiClient().executeRequest(config, {
                ...values,
                parentId: selectedCategory,
            });

            const { data } = response;
            if (data.id) {
                navigate('/admin/categories');
            }
        } catch (e) {
            console.log('Unexpected error:', e);
        }
    };

    if (isLoading) {
        return <>Loading...</>;
    }

    return (
        <>
            <PageHeader title={params.id ? 'Edit Category' : 'Create Category'}>
                <Breadcrumb />
            </PageHeader>

            <CategoryForm
                onSubmit={onSubmit}
                categoryData={categoryData}
                setSelectedCategory={setSelectedCategory}
                selectedCategory={selectedCategory}
            />
        </>
    );
};

export default CategoryFormPage;
