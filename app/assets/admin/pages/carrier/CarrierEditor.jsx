import { useParams } from 'react-router-dom';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import React from 'react';
import CarrierForm from '@/admin/features/carrier/components/CarrierForm';

const CarrierEditor = () => {
  const params = useParams();


  return (
    <>
    <PageHeader title={params.id ? 'Edytuj' : 'Dodaj'}>
      <Breadcrumb />
    </PageHeader>
    <CarrierForm params={params} />
  </>
);
}
export default CarrierEditor;
