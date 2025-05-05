import Input from '@/admin/components/form/controls/Input';
import { validationRules } from '@/admin/utils/validationRules';
import FormCategoryTree from '@/admin/components/category-tree/FormCategoryTree';
import { Controller } from 'react-hook-form';
import Textarea from '@/admin/components/form/controls/Textarea';
import { normalizeFiles } from '@/admin/utils/helper';
import { useDropzoneLogic } from '@/admin/hooks/useDropzoneLogic';
import Heading from '@/admin/components/common/Heading';
import Dropzone from '@/admin/components/form/dropzone/Dropzone';
import DropzoneThumbnail from '@/admin/components/form/dropzone/DropzoneThumbnail';
import Switch from '@/admin/components/form/controls/Switch';
import LabelNameIcon from '@/images/icons/label-name.svg';

const CategoryFormMainColumn = ({ register, fieldErrors, formData, setFormData, setValue, params, watch, control }) => {
    const categoryImage = normalizeFiles(formData?.image);

    const setDropzoneValue = (image) => {
        setValue('image', image);
        setFormData((prevFormData) => ({
            ...prevFormData,
            image,
        }));
    };

    const { onDrop, errors, removeFile } = useDropzoneLogic(setDropzoneValue, categoryImage);

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
                icon={<LabelNameIcon className="text-gray-500" />}
            />

            <Input
                {...register('slug')}
                type="text"
                id="slug"
                label="Przyjazny url"
                hasError={!!fieldErrors?.slug}
                errorMessage={fieldErrors?.slug?.message}
            />

            <Controller
                name="description"
                control={control}
                defaultValue=""
                render={({ field }) => <Textarea value={field.value} onChange={field.onChange} title="Opis" />}
            />

            {formData.tree && formData.tree.length > 0 && (
                <FormCategoryTree
                    titleSection="Kategoria nadrzędna"
                    hasError={!!fieldErrors?.parentCategoryId}
                    errorMessage={fieldErrors?.parentCategoryId?.message}
                    register={register('parentCategoryId')}
                    disabledCategoryId={params.id ?? null}
                    categories={formData.tree || []}
                    selected={formData.parentCategoryId}
                    watch={watch}
                    nameWatchedValue="parentCategoryId"
                />
            )}

            <Heading level="h4">
                <span className="flex items-center">Miniaturka</span>
            </Heading>
            <Dropzone onDrop={onDrop} errors={errors} containerClasses="relative max-w-lg" variant="mainColumn">
                {categoryImage.length > 0 &&
                    categoryImage.map((file, key) => (
                        <DropzoneThumbnail file={file} removeFile={removeFile} variant="single" key={key} index={key} />
                    ))}
            </Dropzone>
            <Switch label="Aktywny?" {...register('isActive')} />
        </>
    );
};

export default CategoryFormMainColumn;
