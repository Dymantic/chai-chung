<table>
    <thead>
        <tr>
            <th>BDT</th>
            <th>PRCTR</th>
            <th>RPTLINE</th>
            <th>X_RLDESC</th>
            <th>X_RLNAME</th>
            <th>AMT</th>
        </tr>
    </thead>
    <tbody>
    @foreach($franchises as $franchise)
        @include('admin.reports.macdonalds.franchise', [
            'franchise' => $franchise['report'],
            'branch_id' => $franchise['company_id'],
            'date' => $date,
        ])
    @endforeach
    </tbody>
</table>
