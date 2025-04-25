import { validationRules } from '@/admin/utils/validationRules';
import Input from '@/admin/components/form/controls/Input';
import Dropzone from '@/admin/components/form/dropzone/Dropzone';
import DropzoneThumbnail from '@/admin/components/form/dropzone/DropzoneThumbnail';
import Heading from '@/admin/components/common/Heading';
import { normalizeFiles } from '@/admin/utils/helper';
import { useDropzoneLogic } from '@/admin/hooks/useDropzoneLogic';
import Switch from '@/admin/components/form/controls/Switch';

const VendorFormMainColumn = ({register, fieldErrors, formData, setFormData, setValue}) => {
  const formDataImage = normalizeFiles(formData?.image);

  const setDropzoneValue = (image) => {
    setValue('image', image);
    setFormData((prevFormData) => ({
      ...prevFormData,
      image,
    }));
  };

  const { onDrop, errors, removeFile } = useDropzoneLogic(setDropzoneValue, formDataImage);

 return (
   <>
     <Input
       {...register('name', {
         ...validationRules.required(),
         ...validationRules.minLength(3),
       })}
       type="text"
       id="name"
       label="Nazwa"
       hasError={!!fieldErrors?.name}
       errorMessage={fieldErrors?.name?.message}
       isRequired
     />

     <Heading level="h4">
       <span className="flex items-center">Miniaturka</span>
     </Heading>
     <Dropzone onDrop={onDrop} errors={errors} containerClasses="relative max-w-lg" variant="mainColumn">
       {formDataImage.length > 0 &&
         formDataImage.map((file, key) => (
           <DropzoneThumbnail
             file={file}
             removeFile={removeFile}
             variant="single"
             key={key}
             index={key}
           />
         ))}
     </Dropzone>

     <Switch label="Aktywny?" {...register('isActive')} />
   </>
 )
}

export default VendorFormMainColumn;
