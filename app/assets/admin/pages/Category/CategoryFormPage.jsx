import {useNavigate, useParams} from "react-router-dom";
import Breadcrumb from "../../components/Navigation/Breadcrumb";
import PageHeader from "../../components/Layout/PageHeader";
import {useForm} from "react-hook-form";
import AppButton from "../../components/Common/AppButton";
import Input from "../../../shared/components/Input";
import React, {useEffect, useState} from "react";
import Card from "../../components/Card";
import restApiClient from "../../../shared/api/RestApiClient";
import CategoryTree from "../../components/CategoryTree/CategoryTree";

function CategoryFormPage({}) {
    const navigate = useNavigate();
    const {
        register,
        handleSubmit,
        setValue,
        watch,
        formState: { errors ,}
    } = useForm();
    const [selectedCategory, setSelectedCategory] = useState(null);
    const [categoryTree, setCategoryTree] = useState([]);
    const createConfig = restApiClient().createConfig('category/create', 'POST');

    useEffect(() => {
        (async () => {
            const config = restApiClient().createConfig('category/form-data', 'GET');
            restApiClient().sendRequest(config).then(result => {
                setCategoryTree(result);
            })
        })();
    }, []);

    const onSubmit = async (values) => {
        try {
            const response = await restApiClient().sendRequest(createConfig, {
                ...values,
                parentId: selectedCategory
            });
            const { id } = response;

            if (id) {
                navigate('/admin/categories');
            }

        } catch (e) {
            console.log('Unexpected error:', e);
        }
    }

    if (categoryTree.length === 0 ) {
        return <>Loading...</>;
    }

    return (
        <>
            <PageHeader title={'Create Category'}>
                <Breadcrumb />
            </PageHeader>


            <form onSubmit={handleSubmit(onSubmit)}>
                <div className="flex flex-row gap-4 mt-5">
                    <div className="flex flex-col w-full gap-4">
                        <Card>
                            <h3 className="text-lg font-semibold">Basic information</h3>
                            <div className="flex flex-col gap-4 mt-5">
                                <Input
                                    {...register('name', {
                                        required: 'Pole nazwa jest wymagana',
                                        minLength: {
                                            value: 3,
                                            message: 'Nazwa musi mieć co najmniej 3 znaki',
                                        },
                                    })}
                                    type="text"
                                    id="name"
                                    label="Nazwa"
                                    hasError={errors.hasOwnProperty('name')}
                                    errorMessage={errors?.name?.message}
                                />
                                <Input
                                    {...register('description')}
                                    type="text"
                                    id="description"
                                    label="Opis"
                                    hasError={errors.hasOwnProperty('description')}
                                    errorMessage={errors?.description?.message}
                                />

                                <div>
                                    <h1>Parent category</h1>
                                    <Card additionalClasses="overflow-auto">
                                        <CategoryTree
                                            categories={categoryTree}
                                            selected={selectedCategory}
                                            setSelected={setSelectedCategory}
                                            register={register}
                                            setValue={setValue}
                                        />
                                    </Card>
                                </div>
                            </div>
                        </Card>
                    </div>
                    <Card additionalClasses="w-[500px] h-full">
                        <div className="flex flex-col gap-4">
                            <h3 className="text-lg font-semibold">Attribute</h3>
                            <label className="inline-flex items-center cursor-pointer">
                                <input
                                    {...register('isActive')}
                                    type="checkbox"
                                    value=""
                                    className="sr-only peer"
                                />
                                <div
                                    className="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
                                <span
                                    className="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Active</span>
                            </label>
                        </div>
                    </Card>
                </div>
                <div className="sticky bottom-0 left-0 right-0 z-10 mt-8 bg-white  p-4 flex justify-end">
                    <AppButton variant="primary" type="submit" additionalClasses="px-4 py-2" >Zapisz </AppButton>
                </div>
            </form>
        </>
    )
}

export default CategoryFormPage;
