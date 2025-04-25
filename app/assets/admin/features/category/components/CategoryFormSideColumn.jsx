import FormSidePanel from '@/admin/components/form/FormSidePanel';
import Dropzone from '@/admin/components/form/dropzone/Dropzone';
import { useDropzoneLogic } from '@/admin/hooks/useDropzoneLogic';
import { normalizeFiles } from '@/admin/utils/helper';
import Switch from '@/admin/components/form/controls/Switch';
import DropzoneThumbnail from '@/admin/components/form/dropzone/DropzoneThumbnail';
import Heading from '@/admin/components/common/Heading';

const CategoryFormSideColumn = ({ register, categoryFormData, setCategoryFormData, setValue }) => {
    const categoryFormDataImage = normalizeFiles(categoryFormData?.image);

    const setDropzoneValue = (image) => {
        setValue('image', image);
        setCategoryFormData((prevFormData) => ({
            ...prevFormData,
            image,
        }));
    };

    const { onDrop, errors, removeFile } = useDropzoneLogic(setDropzoneValue, categoryFormDataImage);


    return (
        <div className="flex flex-col h-full gap-[2.5rem]">
            <FormSidePanel sectionTitle="Dodatkowe Informacje">
                <Heading level="h4">
                    <span className="flex items-center">Avatar </span>
                </Heading>
                <Dropzone onDrop={onDrop} errors={errors} containerClasses="relative">
                    {categoryFormDataImage.length > 0 &&
                        categoryFormDataImage.map((file, key) => (
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
            </FormSidePanel>
        </div>
    );
};
export default CategoryFormSideColumn;
