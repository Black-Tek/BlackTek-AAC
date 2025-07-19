import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

import HeadingSmall from '@/components/heading-small';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import SettingsLayout from '@/layouts/settings/layout';
import { ArrowLeft, LoaderCircle } from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Character',
        href: '/settings/character',
    },
    {
        title: 'Create Character',
        href: '/settings/character/create',
    },
];

type CharacterForm = {
    name: string;
    sex: string;
    vocation: string;
    town_id: string;
};

interface VocationOption {
    id: number;
    name: string;
}

interface TownOption {
    id: number;
    name: string;
}

interface SexOption {
    id: string;
    name: string;
}

interface CharacterCreateProps {
    vocations: Record<string, VocationOption>;
    towns: Record<string, TownOption>;
    sexes: SexOption;
    characterCount: number;
    maxCharacters: number;
    canCreate: boolean;
}

export default function CharacterCreate({ vocations, towns, sexes, characterCount, maxCharacters, canCreate }: CharacterCreateProps) {
    const { data, setData, post, processing, errors, reset } = useForm<CharacterForm>({
        name: '',
        sex: '',
        vocation: '',
        town_id: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('character.store'), {
            onSuccess: () => reset('name'),
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create Character" />

            <SettingsLayout>
                <div className="space-y-6">
                    <div className="flex justify-between gap-4">
                        <HeadingSmall title="Create Character" description={`Create a new character (${characterCount}/${maxCharacters})`} />
                        <Link href={route('character.index')}>
                            <Button variant="outline" size="sm">
                                <ArrowLeft className="mr-2 h-4 w-4" />
                                Back to Characters
                            </Button>
                        </Link>
                    </div>

                    {!canCreate && (
                        <Card className="border-red-200 bg-red-50 dark:border-red-900 dark:bg-red-950">
                            <CardHeader>
                                <CardTitle className="text-red-800 dark:text-red-200">Character Limit Reached</CardTitle>
                                <CardDescription className="text-red-600 dark:text-red-400">
                                    You have reached the maximum number of characters allowed ({maxCharacters}). Please delete a character before
                                    creating a new one.
                                </CardDescription>
                            </CardHeader>
                        </Card>
                    )}

                    {canCreate && (
                        <Card>
                            <CardHeader>
                                <CardTitle>Character Information</CardTitle>
                                <CardDescription>Fill in the details for your new character.</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <form onSubmit={submit} className="space-y-6">
                                    <div className="grid gap-6">
                                        {/* Character Name */}
                                        <div className="grid gap-2">
                                            <Label htmlFor="name">Character Name</Label>
                                            <Input
                                                id="name"
                                                type="text"
                                                value={data.name}
                                                onChange={(e) => setData('name', e.target.value)}
                                                placeholder="Enter character name"
                                                disabled={processing}
                                                autoFocus
                                            />
                                            <InputError message={errors.name} />
                                            <p className="text-sm text-muted-foreground">
                                                4-29 characters, must start with a capital letter, only letters and spaces allowed.
                                            </p>
                                        </div>

                                        {/* Sex Selection */}
                                        <div className="grid gap-2">
                                            <Label>Sex</Label>
                                            <Select value={data.sex} onValueChange={(value) => setData('sex', value)} disabled={processing}>
                                                <SelectTrigger>
                                                    <SelectValue placeholder="Select a sex" />
                                                </SelectTrigger>
                                                <SelectContent>
                                                    {Object.values(sexes).map((sex) => (
                                                        <SelectItem key={sex.id} value={sex.id.toString()}>
                                                            {sex.name}
                                                        </SelectItem>
                                                    ))}
                                                </SelectContent>
                                            </Select>
                                            <InputError message={errors.sex} />
                                        </div>

                                        {/* Vocation Selection */}
                                        <div className="grid gap-2">
                                            <Label htmlFor="vocation">Vocation</Label>
                                            <Select value={data.vocation} onValueChange={(value) => setData('vocation', value)} disabled={processing}>
                                                <SelectTrigger>
                                                    <SelectValue placeholder="Select a vocation" />
                                                </SelectTrigger>
                                                <SelectContent>
                                                    {Object.values(vocations).map((vocation) => (
                                                        <SelectItem key={vocation.id} value={vocation.id.toString()}>
                                                            {vocation.name}
                                                        </SelectItem>
                                                    ))}
                                                </SelectContent>
                                            </Select>
                                            <InputError message={errors.vocation} />
                                        </div>

                                        {/* Town Selection */}
                                        <div className="grid gap-2">
                                            <Label htmlFor="town">Starting Town</Label>
                                            <Select value={data.town_id} onValueChange={(value) => setData('town_id', value)} disabled={processing}>
                                                <SelectTrigger>
                                                    <SelectValue placeholder="Select a town" />
                                                </SelectTrigger>
                                                <SelectContent>
                                                    {Object.values(towns).map((town) => (
                                                        <SelectItem key={town.id} value={town.id.toString()}>
                                                            {town.name}
                                                        </SelectItem>
                                                    ))}
                                                </SelectContent>
                                            </Select>
                                            <InputError message={errors.town_id} />
                                        </div>
                                    </div>

                                    <div className="flex gap-4">
                                        <Button type="submit" disabled={processing}>
                                            {processing && <LoaderCircle className="mr-2 h-4 w-4 animate-spin" />}
                                            Create Character
                                        </Button>
                                        <Link href="/settings/character">
                                            <Button type="button" variant="outline" disabled={processing}>
                                                Cancel
                                            </Button>
                                        </Link>
                                    </div>
                                </form>
                            </CardContent>
                        </Card>
                    )}
                </div>
            </SettingsLayout>
        </AppLayout>
    );
}
