import { useParams } from 'react-router-dom';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import React from 'react';
import SettingForm from '@/admin/features/setting/components/SettingForm';

const SettingEditor = () => {
  const params = useParams();

  return (
    <>
      <PageHeader title={params.id ? 'Edytuj' : 'Dodaj'}>
        <Breadcrumb />
      </PageHeader>
      <SettingForm params={params} />
    </>
  );
}

export default SettingEditor;
