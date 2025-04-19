import ModalHeader from '@/admin/components/modal/ModalHeader';
import ModalBody from '@/admin/components/modal/ModalBody';
import React from 'react';

const ModalFile = ({name, preview}) => (
  <>
    <ModalHeader title={name} />
    <ModalBody>
      <div>
        <img src={preview} alt={name} />
      </div>
    </ModalBody>
  </>
)

export default ModalFile;
