import FormSidePanel from '@/admin/components/form/FormSidePanel';
import Dropzone from '@/admin/components/form/dropzone/Dropzone';
import Switch from '@/admin/components/form/controls/Switch';
import { normalizeFiles } from '@/admin/utils/helper';
import { useDropzoneLogic } from '@/admin/hooks/useDropzoneLogic';
import DropzoneThumbnail from '@/admin/components/form/dropzone/DropzoneThumbnail';

const VendorFormSideColumn = ({ register, setValue, formData, setFormData }) => {
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
        <div className="flex flex-col h-full gap-[2.5rem]">
            <FormSidePanel sectionTitle="Zdjęcie">
                <Dropzone onDrop={onDrop} errors={errors} containerClasses="relative">
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
            </FormSidePanel>
            <FormSidePanel sectionTitle="Atrybuty">
                <Switch label="Aktywny?" {...register('isActive')} />
            </FormSidePanel>
        </div>
    );
};

export default VendorFormSideColumn;
