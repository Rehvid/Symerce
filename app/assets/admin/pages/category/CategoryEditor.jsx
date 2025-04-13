import { useParams } from 'react-router-dom';
import React from 'react';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import CategoryForm from '@/admin/features/category/components/CategoryForm';

const CategoryEditor = () => {
    const params = useParams();

    return (
        <>
          <PageHeader title={params.id ? 'Edit Category' : 'Create Category'} >
            <Breadcrumb />
          </PageHeader>
            <CategoryForm params={params} />
        </>
    );
};

export default CategoryEditor;
