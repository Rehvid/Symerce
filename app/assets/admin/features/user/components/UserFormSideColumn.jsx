import FormSidePanel from '@/admin/components/form/FormSidePanel';
import Dropzone from '@/admin/components/form/dropzone/Dropzone';
import DropzonePreviewActions from '@/admin/components/form/dropzone/DropzonePreviewActions';
import Switch from '@/admin/components/form/controls/Switch';
import React from 'react';
import ModalHeader from '@/admin/components/modal/ModalHeader';
import ModalBody from '@/admin/components/modal/ModalBody';
import { useDropzoneLogic } from '@/admin/hooks/useDropzoneLogic';
import { normalizeFiles } from '@/admin/utils/helper';

const UserFormSideColumn = ({register, setValue, userData, setUserData}) => {
  const userDataAvatar = normalizeFiles(userData?.avatar);
  const setDropzoneValue = (avatar) => {
    setValue('avatar', avatar);
    setUserData((prevFormData) => ({
      ...prevFormData,
      avatar: avatar
    }));
  };

  const { onDrop, errors, removeFile } = useDropzoneLogic(setDropzoneValue, userData);

  const renderModal = (file) => (
    <>
      <ModalHeader title={file.name} />
      <ModalBody>
        <div>
          <img src={file.preview} alt={file.name} />
        </div>
      </ModalBody>
    </>
  );

  return(
    <div className="flex flex-col h-full gap-[2.5rem]">
      <FormSidePanel sectionTitle="Zdjęcie">
        <Dropzone
          onDrop={onDrop}
          errors={errors}
          containerClasses="relative"
        >
          {userDataAvatar.length > 0 && (
            userDataAvatar.map((file, key) => (
              <div className="absolute flex top-0 h-full w-full rounded-lg" key={key}>
                <img
                  className="rounded-lg mx-auto object-cover w-full"
                  src={file.preview}
                  alt={file.name}
                />
                <div className="absolute rounded-lg transition-all w-full h-full inset-0 flex items-center justify-center gap-3 hover:backdrop-blur-xl">
                  <DropzonePreviewActions
                    renderModal={renderModal}
                    removeFile={removeFile}
                    file={file}
                  />
                </div>
              </div>
            ))
          )}
        </Dropzone>
      </FormSidePanel>
      <FormSidePanel sectionTitle="Atrybuty">
        <Switch label="Aktywny?" {...register('isActive')} />
      </FormSidePanel>
    </div>
  )
}

export default UserFormSideColumn;
