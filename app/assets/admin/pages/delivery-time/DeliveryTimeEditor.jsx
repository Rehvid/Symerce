import { useParams } from 'react-router-dom';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import CarrierForm from '@/admin/features/carrier/components/CarrierForm';
import React from 'react';
import DeliveryTimeForm from '@/admin/features/delivery-time/components/DeliveryTimeForm';

const DeliveryTimeEditor = () => {
  const params = useParams();


  return (
    <>
      <PageHeader title={params.id ? 'Edytuj' : 'Dodaj'}>
        <Breadcrumb />
      </PageHeader>
      <DeliveryTimeForm params={params} />
    </>
  );
}
export default DeliveryTimeEditor;
