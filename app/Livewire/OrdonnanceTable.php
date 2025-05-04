<?php
namespace App\Http\Livewire;

use Livewire\Component;
use Filament\Tables;
use App\Models\Ordonnance; // Assurez-vous que vous avez le bon modèle.

class OrdonnanceTable extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    public $consultationId;

    public function render()
    {
        return view('livewire.ordonnance-table');
    }

    public function getTableQuery()
    {
        return Ordonnance::where('consultation_id', $this->consultationId);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('recommandations')->label('Nom de l’ordonnance'),
                Tables\Columns\TextColumn::make('date_ordonnance')->label('Date de création')->date(),
            ])
            ->filters([/* Ajoutez des filtres ici */])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ]);
    }
}
