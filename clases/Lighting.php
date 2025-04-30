<?php
class Lighting extends Connection
{
    public function getAllLamps($zone = 'all')
    {
        $sql = "SELECT lamps.lamp_id, lamps.lamp_name, lamp_on,
                       lamp_models.model_part_number, lamp_models.model_wattage,
                       zones.zone_name
                FROM lamps
                INNER JOIN lamp_models ON lamps.lamp_model = lamp_models.model_id
                INNER JOIN zones ON lamps.lamp_zone = zones.zone_id";

        if ($zone !== 'all') {
            $sql .= " WHERE zones.zone_id = ?";
        }

        $sql .= " ORDER BY lamps.lamp_id";

        $stmt = $this->pdo->prepare($sql);
        if ($zone !== 'all') {
            $stmt->execute([$zone]);
        } else {
            $stmt->execute();
        }

        $lamps = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $lamps[] = new Lamp($row['lamp_id'], $row['lamp_name'], $row['lamp_on'], $row['model_part_number'], $row['model_wattage'], $row['zone_name']);
        }
        return $lamps;
    }

    public function drawLampsList($lamps)
    {
        foreach ($lamps as $lamp) {
            $icon = $lamp->isOn() ? 'img/bulb-icon-on.png' : 'img/bulb-icon-off.png';
            $newStatus = $lamp->isOn() ? 0 : 1;
            echo "<div>
                    <img src='$icon' width='20' />
                    {$lamp->getName()} - {$lamp->getModel()} - {$lamp->getWattage()}W - {$lamp->getZone()}
                    <a href='changestatus.php?id={$lamp->getId()}&status=$newStatus'>Toggle</a>
                  </div>";
        }
    }

    public function getTotalPowerOn()
    {
        $sql = "SELECT zones.zone_name, SUM(lamp_models.model_wattage) as total_power
                FROM lamps
                INNER JOIN lamp_models ON lamp_model = lamp_models.model_id
                INNER JOIN zones ON lamps.lamp_zone = zones.zone_id
                WHERE lamp_on = 1
                GROUP BY zones.zone_name";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function drawZonesOptions($current = 'all')
    {
        $stmt = $this->pdo->query("SELECT * FROM zones");
        echo "<form method='GET'><select name='zone' onchange='this.form.submit()'>";
        echo "<option value='all'" . ($current === 'all' ? ' selected' : '') . ">Todas</option>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $selected = $row['zone_id'] == $current ? ' selected' : '';
            echo "<option value='{$row['zone_id']}'$selected>{$row['zone_name']}</option>";
        }
        echo "</select></form>";
    }

    public function changeStatus($id, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE lamps SET lamp_on = ? WHERE lamp_id = ?");
        $stmt->execute([$status, $id]);
    }
}
