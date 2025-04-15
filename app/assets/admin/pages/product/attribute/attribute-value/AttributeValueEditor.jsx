import { useParams } from 'react-router-dom';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import AttributeForm from '@/admin/features/product/attribute/components/AttributeForm';
import React from 'react';
import AttributeValueForm from '@/admin/features/product/attribute/attribute-value/components/AttributeValueForm';

const AttributeValueEditor = () => {
  const params = useParams();

  return (
    <>
      <PageHeader title={params.id ? 'Edytuj' : 'Dodaj'}>
        <Breadcrumb />
      </PageHeader>
      <AttributeValueForm params={params} />
    </>
  );
}

export default AttributeValueEditor;
