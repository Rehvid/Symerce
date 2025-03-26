import {useNavigate, useParams} from "react-router-dom";
import Breadcrumb from "../../components/Navigation/Breadcrumb";
import PageHeader from "../../components/Layout/PageHeader";
import React, {useEffect, useState} from "react";
import restApiClient from "../../../shared/api/RestApiClient";
import CategoryForm from "./Partials/CategoryForm";

function CategoryFormPage({}) {
    const params = useParams();
    const id = params.id ?? null;
    const navigate = useNavigate();

    const [selectedCategory, setSelectedCategory] = useState(null);
    const [didInit, setDidInit] = useState(false);
    const [categoryData, setCategoryData] = useState({});


    useEffect(() => {
        (async () => {
            const config = restApiClient().createConfig(`category/${id}/form-data`, 'GET');
            restApiClient().sendRequest(config).then(result => {
                setCategoryData(result.data);
                setDidInit(true);
            });
        })();
    }, [id]);

    const onSubmit = async (values) => {
        try {
            const config = params.id
                ? restApiClient().createConfig(`category/${params.id}/update`, 'PUT')
                : restApiClient().createConfig('category/create', 'POST');


            const response = await restApiClient().sendRequest(config, {
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
    }

    if (!didInit) {
        return <>Loading...</>;
    }

    return (
        <>
            <PageHeader title={id ? 'Edit Category' : 'Create Category'}>
                <Breadcrumb />
            </PageHeader>

            <CategoryForm
                onSubmit={onSubmit}
                categoryData={categoryData}
                setSelectedCategory={setSelectedCategory}
                selectedCategory={selectedCategory}
            />
        </>
    )
}

export default CategoryFormPage;
