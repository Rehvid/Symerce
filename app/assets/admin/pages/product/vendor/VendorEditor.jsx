import { useParams } from 'react-router-dom';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import React from 'react';
import VendorForm from '@/admin/features/product/vendor/components/VendorForm';

const VendorEditor = () => {
  const params = useParams();

  return (
    <>
      <PageHeader title={params.id ? 'Edytuj' : 'Dodaj'}>
        <Breadcrumb />
      </PageHeader>
      <VendorForm params={params} />
    </>
  );
}

export default VendorEditor;
