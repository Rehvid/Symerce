import { useParams } from 'react-router-dom';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import CarrierForm from '@/admin/features/carrier/components/CarrierForm';
import React from 'react';
import CurrencyForm from '@/admin/features/currency/components/CurrencyForm';

const CurrencyEditor = () => {
  const params = useParams();


  return (
    <>
      <PageHeader title={params.id ? 'Edytuj' : 'Dodaj'}>
        <Breadcrumb />
      </PageHeader>
      <CurrencyForm params={params} />
    </>
  );
}

export default CurrencyEditor;

