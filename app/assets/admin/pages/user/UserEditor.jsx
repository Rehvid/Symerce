import { useParams } from 'react-router-dom';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import React from 'react';
import UserForm from '@/admin/features/user/components/UserForm';

const UserEditor = () => {
  const params = useParams();

  return (
    <>
      <PageHeader title={params.id ? 'Edit User' : 'Create User'}>
        <Breadcrumb />
      </PageHeader>
      <UserForm params={params} />
    </>
  );
}

export default UserEditor;
