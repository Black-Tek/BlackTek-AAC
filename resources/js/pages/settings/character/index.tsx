import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

import { type Character, columns } from '@/components/character/table/columns';
import { DataTable } from '@/components/data-table';
import HeadingSmall from '@/components/heading-small';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import SettingsLayout from '@/layouts/settings/layout';
import { Plus } from 'lucide-react';
import { route } from 'ziggy-js';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Character settings',
        href: '/settings/character',
    },
];

export default function CharacterPage({ characters }: { characters: Character[] }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Character settings" />

            <SettingsLayout>
                <div className="space-y-6">
                    <div className="flex justify-between gap-4">
                        <HeadingSmall title="Characters" description="Manage your characters" />
                        <Link href={route('character.create')}>
                            <Button size="sm">
                                <Plus className="mr-2 h-4 w-4" />
                                Create Character
                            </Button>
                        </Link>
                    </div>

                    <DataTable columns={columns} data={characters} searchKey="name" searchPlaceholder="Search characters..." />
                </div>
            </SettingsLayout>
        </AppLayout>
    );
}
