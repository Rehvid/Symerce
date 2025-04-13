import { useParams } from 'react-router-dom';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import React from 'react';
import ProductForm from '@/admin/features/product/components/ProductForm';

const ProductEditor = () => {
  const params = useParams();

  return (
    <>
      <PageHeader title={params.id ? 'Edit Product' : 'Create Product'}>
        <Breadcrumb />
      </PageHeader>
      <ProductForm params={params} />
    </>
  );
}

export default ProductEditor;
